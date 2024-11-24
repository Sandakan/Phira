let chatWebSocket;
let chatList = [];
let chatMessages = [];

const body = document.body;
const BASE_URL = body.dataset.baseUrl;
const userId = body.dataset.userId;
const chatListContainer = document.getElementById('chat-list');
const chatContainer = document.getElementById('chat-container');
const queryParams = new URLSearchParams(window.location.search);
const chatId = queryParams.get('chat_id');

document.addEventListener('DOMContentLoaded', async () => {
	console.log(userId);

	if (userId) {
		initializeChatWebSocket(userId);
		displayUserChatList(userId).then((userChatList) => {
			if (userChatList && chatId) {
				const chat_data = userChatList.find((c) => c.chat_id == chatId);
				if (chat_data) {
					displayChatContainer(chat_data);
					displayChatMessages(chatId);
				} else alert('Chat not found.');
			}
		});
	}
});

function initializeChatWebSocket(userId) {
	chatWebSocket = new WebSocket(`ws://localhost:8080/chats?user_id=${userId}`);

	chatWebSocket.onopen = () => {
		console.log('Connected to WebSocket server');
	};

	chatWebSocket.onmessage = (event) => {
		const message = JSON.parse(event.data);
		console.log(`New message in chat ${message.chat_id} from ${message.sender_id}: ${message.content}`);

		if (message.sender_id == userId) return;
		insertMessage({
			chat_id: message.chat_id,
			sender_id: message.sender_id,
			receiver_id: message.receiver_id,
			message: message.content,
			updated_at: new Date().toISOString(),
		});
	};

	chatWebSocket.onerror = () => {
		alert('WebSocket connection failed. Try again by reloading the page.');
	};
}

// Sending a message
function sendMessage(receiver_id) {
	if (!chatWebSocket) {
		console.error('WebSocket is not initialized.');
		return;
	}

	const messageInput = document.getElementById('message-input');
	if (!messageInput) return alert('Message input not found.');

	const msg = JSON.stringify({
		chat_id: parseInt(chatId),
		sender_id: parseInt(userId),
		receiver_id,
		content: messageInput.value,
	});
	chatWebSocket?.send(msg);

	insertMessage({
		chat_id: parseInt(chatId),
		sender_id: parseInt(userId),
		receiver_id,
		message: messageInput.value,
		updated_at: new Date().toISOString(),
	});
}

function getActivePageClass(url) {
	const currentUrl = window.location.href.replace(window.location.origin, '');
	const matchingUrl = new URL(url);
	const strippedMatchingUrl = matchingUrl.href.replace(matchingUrl.origin, '');

	return currentUrl.includes(strippedMatchingUrl) ? 'active' : 'not-active';
}

function getTimeDifference(timestamp) {
	if (!timestamp) return '';

	const timeDifference = Date.now() - new Date(timestamp).getTime();
	const oneDay = 24 * 60 * 60 * 1000;
	const time =
		timeDifference < oneDay ? new Date(timestamp).toLocaleTimeString() : new Date(timestamp).toLocaleDateString();

	return time;
}

function generateUserChat(chat_data) {
	const {
		chat_id,
		match_id,
		interacted_user_id,
		interacted_user_first_name,
		interacted_user_last_name,
		interacted_user_profile_picture,
		last_message,
		last_message_time,
	} = chat_data;

	const profile_picture_url = `${BASE_URL}/private/media/user_photos/${interacted_user_profile_picture}`;
	const chat_url = `${BASE_URL}/pages/app/chats.php?chat_id=${chat_id}`;
	const chat_active_class = getActivePageClass(chat_url);
	const message_timestamp = last_message_time ? new Date(last_message_time).toLocaleString() : '';

	const chatElement = `
        <a href="${chat_url}" class="chat-profile ${chat_active_class}" data-interacted-user-id="${interacted_user_id}" data-chat-id="${chat_id}" data-match-id="${match_id}">
            <img src="${profile_picture_url}" alt="" class="profile-img">
            <div class="chat-info-container">
                <div class="profile-info">
                    <h2>${interacted_user_first_name} ${interacted_user_last_name}</h2>
                    <p>${last_message ?? ''}</p>
                </div>
                <p title="${message_timestamp}">${getTimeDifference(last_message_time) ?? ''}</p>
            </div>
        </a>
    `;

	return chatElement;
}

async function displayUserChatList(user_id) {
	if (chatListContainer) {
		return fetch(`${BASE_URL}/server/chat.server.php?reason=get_user_chat_list&user_id=${user_id}`)
			.then((response) => response.json())
			.then((data) => {
				console.log(data);
				const { userChatList, success } = data;

				chatList = userChatList;

				if (success) {
					chatListContainer.innerHTML = '';
					userChatList.forEach((chat_data) => {
						const chatElement = generateUserChat(chat_data);
						chatListContainer.insertAdjacentHTML('beforeend', chatElement);
					});
				}

				return userChatList;
			})
			.catch((error) => console.error(error));
	}
}
