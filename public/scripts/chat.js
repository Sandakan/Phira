import getActivePageClass from './getActivePageClass.js';
import getTimeDifference from './getTimeDifference.js';

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
		fetchUserChatList(userId).then((userChatList) => {
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

function sendMessageNotification(sender_name, message_content) {
	if (!('Notification' in window) && !document.hasFocus()) {
		// Check if the browser supports notifications
		alert('This browser does not support desktop notification');
	} else if (Notification.permission === 'granted') {
		// Check whether notification permissions have already been granted;
		// if so, create a notification
		const notification = new Notification(`New message from ${sender_name}`, { body: message_content });
		// …
	} else if (Notification.permission !== 'denied') {
		// We need to ask the user for permission
		Notification.requestPermission().then((permission) => {
			// If the user accepts, let's create a notification
			if (permission === 'granted') {
				const notification = new Notification(`New message from ${sender_name}`, { body: message_content });
				// …
			}
		});
	}
}

function initializeChatWebSocket(userId) {
	chatWebSocket = new WebSocket(`ws://localhost:8080/chats?user_id=${userId}`);

	chatWebSocket.onopen = () => {
		console.log('Connected to WebSocket server');
	};

	chatWebSocket.onmessage = (event) => {
		const message = JSON.parse(event.data);
		console.log(`New message in chat ${message.chat_id} from ${message.sender_id}: ${message.content}`);

		if (message.sender_id == userId) return;

		const parsedMessage = {
			chat_id: message.chat_id,
			sender_id: message.sender_id,
			receiver_id: message.receiver_id,
			message: message.content,
			content: message.content,
			updated_at: new Date().toISOString(),
		};
		insertMessage(parsedMessage);
		updateChatListWithNewLastMessage(parsedMessage);

		const interacted_user_first_name = chatContainer.dataset.interactedUserFirstName ?? 'Phira';
		sendMessageNotification(interacted_user_first_name, message?.content);
	};

	chatWebSocket.onerror = () => {
		alert('WebSocket connection failed. Try again by reloading the page.');
	};
}

function updateChatListWithNewLastMessage(last_message) {
	const existingChat = chatList.find((c) => c.chat_id === last_message.chat_id);
	if (existingChat) {
		existingChat.last_message = last_message.content;
		existingChat.updated_at = last_message.updated_at;
	} else {
		chatList.push(last_message);
	}

	chatList.sort((a, b) => new Date(b.updated_at) - new Date(a.updated_at));
	displayChatList(chatList);
}

// Sending a message
function sendMessage(receiver_id) {
	if (!chatWebSocket) {
		console.error('WebSocket is not initialized.');
		return;
	}

	const messageInput = document.getElementById('message-input');
	if (!messageInput) return alert('Message input not found.');

	const message = messageInput.value.trim();
	if (!message) return alert('Please enter a message.');

	const msg = {
		chat_id: parseInt(chatId),
		sender_id: parseInt(userId),
		receiver_id,
		message,
		content: message,
		updated_at: new Date().toISOString(),
	};
	chatWebSocket?.send(JSON.stringify(msg));

	insertMessage(msg);
	updateChatListWithNewLastMessage(msg);

	messageInput.value = '';
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

function displayChatList(chatList) {
	chatListContainer.innerHTML = '';
	chatList.forEach((chat_data) => {
		const chatElement = generateUserChat(chat_data);
		chatListContainer.insertAdjacentHTML('beforeend', chatElement);
	});
}

async function fetchUserChatList(user_id) {
	if (chatListContainer) {
		return fetch(`${BASE_URL}/server/chat.server.php?reason=get_user_chat_list&user_id=${user_id}`)
			.then((response) => response.json())
			.then((data) => {
				console.log(data);
				const { userChatList, success } = data;

				chatList = userChatList;

				if (success) displayChatList(userChatList);

				return userChatList;
			})
			.catch((error) => console.error(error));
	}
}

function displayChatContainer(chat_data, chat_messages = '') {
	const { interacted_user_id, interacted_user_first_name, interacted_user_last_name, interacted_user_profile_picture } =
		chat_data;

	const chatElement = `
            <div class="user-chat-header">
                <img src="${BASE_URL}/private/media/user_photos/${interacted_user_profile_picture}" alt="">
                <div class="user-info-container">
                    <div class="user-info">
                        <h1>${interacted_user_first_name} ${interacted_user_last_name}</h1>
                        <p>Online</p>
                    </div>
                    <button onclick="toggleSideProfile()" class="btn btn-primary info-btn">
						<span class="privacy-icon material-symbols-rounded">info</span>
					</button>
                </div>
            </div>
            <div class="messages-container" id="chat-messages-container">${chat_messages}</div>
            <div class="message-input-container">
                <textarea class="type-area" id="message-input" placeholder="Type a message..."></textarea>
                <button class="btn btn-primary send-message-button" onclick="sendMessage(${interacted_user_id})"><span class="privacy-icon material-symbols-rounded">send</span></button>
            </div>
    `;

	if (chatContainer) {
		chatContainer.dataset.interactedUserProfilePicture = interacted_user_profile_picture;
		chatContainer.dataset.interactedUserFirstName = interacted_user_first_name;
		chatContainer.dataset.interactedUserLastName = interacted_user_last_name;
		chatContainer.dataset.interactedUserId = interacted_user_id;
		chatContainer.innerHTML = chatElement;

		const messageInput = document.getElementById('message-input');
		messageInput.addEventListener('keydown', (event) => {
			if (event.key === 'Enter') {
				sendMessage(interacted_user_id);
			}
		});
	}
}

function generateMessage(message_data) {
	const { chat_id, sender_id, message, message_media_url, message_type, seen_at, updated_at } = message_data;

	const isSender = sender_id === parseInt(userId);

	const interacted_user_profile_picture = chatContainer.dataset.interactedUserProfilePicture;
	const user_profile_picture = body.dataset.userProfilePicture;

	const profile_picture_url = isSender
		? `${BASE_URL}/private/media/user_photos/${user_profile_picture}`
		: `${BASE_URL}/private/media/user_photos/${interacted_user_profile_picture}`;
	const message_timestamp = updated_at ? new Date(updated_at).toLocaleString() : '';

	const messageElement = `
    <div class="message-container ${
			isSender ? 'sender-message' : 'receiver-message'
		}" data-message-timestamp="${message_timestamp}" data-message-id="${message_data.message_id}">
        <img src="${profile_picture_url}" alt="">
        <div class="message">
            <p class="message-content">${message}</p>
			<span class="message-timestamp" title="${message_timestamp}">${getTimeDifference(message_timestamp)}</span>
        </div>
    </div>`;

	return messageElement;
}

function insertMessage(message_data) {
	const messageElement = generateMessage(message_data);

	const chatMessagesContainer = document.getElementById('chat-messages-container');
	if (chatMessagesContainer) {
		chatMessagesContainer.insertAdjacentHTML('beforeend', messageElement);
	}
}

async function displayChatMessages(chat_id) {
	fetch(`${BASE_URL}/server/chat.server.php?reason=get_chat_messages&chat_id=${chat_id}`)
		.then((response) => response.json())
		.then((data) => {
			console.log(data);
			const { messages, success } = data;

			chatMessages = messages;
			const chatMessagesContainer = document.getElementById('chat-messages-container');

			if (success && chatMessagesContainer) {
				chatMessagesContainer.innerHTML = '';

				chatMessages.forEach((message_data) => insertMessage(message_data));
			}
		})
		.catch((error) => console.error(error));
}

// ----- side panel -----

function toggleSideProfile() {
	const modal = document.getElementById('match-user-profile-container');

	modal?.classList.toggle('hidden');
}

// const block_button = document.getElementById('block-report-btn');
// const block_panel = document.getElementById('block-panel');
// const close_button = document.getElementsByClassName('close')[1];

// block_button.onclick = function () {
// 	block_panel.style.display = 'block';
// };

// close_button.onclick = function () {
// 	block_panel.style.display = 'none';
// };
// window.onclick = function (event) {
// 	if (event.target == modal) {
// 		block_panel.style.display = 'none';
// 	}
// };
