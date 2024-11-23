const body = document.body;
const messageInput = document.getElementById('message-input');
const queryParams = new URLSearchParams(window.location.search);
const chatId = queryParams.get('chat_id');
let chatWebSocket;

document.addEventListener('DOMContentLoaded', () => {
	const userId = body.dataset.userId;

	console.log(userId);

	if (userId) initializeChatWebSocket(userId);
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
