let chatWebSocket;
let chatList = [];

const body = document.body;
const BASE_URL = body.dataset.baseUrl;
const chatListContainer = document.getElementById('chat-list');
const messageInput = document.getElementById('message-input');
const queryParams = new URLSearchParams(window.location.search);
const chatId = queryParams.get('chat_id');

document.addEventListener('DOMContentLoaded', () => {
	const userId = body.dataset.userId;

	console.log(userId);

	if (userId) {
		initializeChatWebSocket(userId);
		displayUserChatList(userId);
	}
});

function initializeChatWebSocket(userId) {
	chatWebSocket = new WebSocket(`ws://localhost:8080/chat?user_id=${userId}`);

	chatWebSocket.onopen = () => {
		console.log('Connected to WebSocket server');
	};

	chatWebSocket.onmessage = (event) => {
		const message = JSON.parse(event.data);
		console.log(`New message in chat ${message.chat_id} from ${message.sender_id}: ${message.content}`);
	};

	chatWebSocket.onerror = () => {
		alert('WebSocket connection failed. Try again by reloading the page.');
	};
}

// Sending a message
function sendMessage() {
	if (!chatWebSocket) {
		console.error('WebSocket is not initialized.');
		return;
	}
	const msg = JSON.stringify({ chat_id: parseInt(chatId), sender_id: 1, receiver_id: 2, content: messageInput.value });
	chatWebSocket?.send(msg);
}

function getActivePageClass(url) {
	const currentUrl = window.location.href.replace(window.location.origin, '');
	const matchingUrl = new URL(url);
	const strippedMatchingUrl = matchingUrl.href.replace(matchingUrl.origin, '');

	return currentUrl.includes(strippedMatchingUrl) ? 'active' : 'not-active';
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

	const chatElement = `
        <a href="${chat_url}" class="chat-profile ${chat_active_class}" data-interacted-user-id="${interacted_user_id}" data-chat-id="${chat_id}" data-match-id="${match_id}">
            <img src="${profile_picture_url}" alt="" class="profile-img">
            <div class="chat-info-container">
                <div class="profile-info">
                    <h2>${interacted_user_first_name} ${interacted_user_last_name}</h2>
                    <p>${last_message ?? ''}</p>
                </div>
                <p>${last_message_time ?? ''}</p>
            </div>
        </a>
    `;

	return chatElement;
}

async function displayUserChatList(user_id) {
	if (chatListContainer) {
		fetch(`${BASE_URL}/server/chat.server.php?reason=get_user_chat_list&user_id=${user_id}`)
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
			})
			.catch((error) => console.error(error));
	}
}

// ----- side panel -----

var modal = document.getElementById("match-user-profile-container");
var user_profile = document.getElementById("info-icon");
var span = document.getElementsByClassName("close")[0];

user_profile.onclick = function() {
	modal.style.display = "block";
}
span.onclick = function() {
	modal.style.display = "none";
}
window.onclick = function(event) {
	if (event.target == modal) {
		modal.style.display = "none";
	}
};


var block_button = document.getElementById("block-report-btn");
var block_panel = document.getElementById("block-panel");
var close_button = document.getElementsByClassName("close")[1];

block_button.onclick = function() {
	block_panel.style.display = "block";
	
}

close_button.onclick = function() {
	block_panel.style.display = "none";
}
window.onclick = function(event) {
	if (event.target == modal) {
		block_panel.style.display = "none";
	}
};