const body = document.body;

document.addEventListener('DOMContentLoaded', () => {
	const userId = body.dataset.userId;
	console.log(userId);

	const ws = new WebSocket(`ws://localhost:8080/chat?user_id=${userId}`);

	ws.onopen = () => {
		console.log('Connected to WebSocket server');
	};

	ws.onmessage = (event) => {
		const message = JSON.parse(event.data);
		console.log(`New message in chat ${message.chat_id} from ${message.sender_id}: ${message.content}`);
	};

	// Sending a message
	function sendMessage(chatId, senderId, receiverId, content) {
		const msg = JSON.stringify({ chat_id: chatId, sender_id: senderId, receiver_id: receiverId, content });
		ws.send(msg);
	}
});
