import getActivePageClass from './getActivePageClass.js';
import getTimeDifference from './getTimeDifference.js';
import calculateElapsedTime from './calculateElapsedTime.js';

const body = document.body;
const BASE_URL = body.dataset.baseUrl;
const userId = body.dataset.userId;
const queryParams = new URLSearchParams(window.location.search);
const notificationCategoryType = queryParams.get('type');

const notificationCategories = [
	{
		id: 1,
		type: 'BIRTHDAY',
		title: 'Birthday Notifications',
		icon: 'cake',
		notifications: [],
	},
	{
		id: 2,
		type: 'MATCH',
		title: 'Match Notifications',
		icon: 'partner_exchange',
		notifications: [],
	},
	{
		id: 3,
		type: 'LIKES',
		title: 'Likes',
		icon: 'favorite',
		notifications: [],
	},
	{
		id: 4,
		type: 'MESSAGE',
		title: 'Unread Messages',
		icon: 'message',
		notifications: [],
	},
];

document.addEventListener('DOMContentLoaded', () => {
	const ws = new WebSocket('ws://localhost:8080/notifications?user_id=' + userId); // Replace with your WebSocket server URL

	const notificationsList = document.getElementById('notifications-list');

	// On WebSocket open
	ws.onopen = () => {
		console.log('WebSocket connection established');
		ws.send(JSON.stringify({ user_id: userId, action: 'subscribe' }));
	};

	// Handle incoming messages
	ws.onmessage = (event) => {
		const notification = JSON.parse(event.data);

		if (notification) {
			const category = notificationCategories.find((category) => category.type === notification.notification_type);

			if (category) {
				const isANewNotification = !category.notifications.find(
					(x) => x.notification_id === notification.notification_id
				);

				if (isANewNotification) {
					category.notifications.push(notification);
					displayCategoryNotificationsContainer(category.type);
					displayNotification(notification);
				}
			}
		}
		// displayNotification(notification);
		console.log(notification);
	};

	// Handle WebSocket close
	ws.onclose = () => {
		console.log('WebSocket connection closed');
	};

	// Handle WebSocket errors
	ws.onerror = (error) => {
		console.error('WebSocket error:', error);
	};

	fetchUserNotifications(userId).then((userNotifications) => {
		displayNotificationCategoryList();

		if (notificationCategoryType) displayCategoryNotificationsContainer(notificationCategoryType);
	});

	// Display notification
	function displayNotification(data) {
		if (!('Notification' in window) && !document.hasFocus()) {
			// Check if the browser supports notifications
			alert('This browser does not support desktop notification');
		} else if (Notification.permission === 'granted') {
			// Check whether notification permissions have already been granted;
			// if so, create a notification
			const notification = new Notification(`New ${data.notification_type} notification from Phira`, {
				body: data.notification,
			});
			// …
		} else if (Notification.permission !== 'denied') {
			// We need to ask the user for permission
			Notification.requestPermission().then((permission) => {
				// If the user accepts, let's create a notification
				if (permission === 'granted') {
					const notification = new Notification(`New ${data.notification_type} notification from Phira`, {
						body: data.notification,
					}); // …
				}
			});
		}
	}
});

function generateNotificationCategory(category) {
	const { id, type, title, icon, notifications } = category;

	const notification_category_url = `${BASE_URL}/pages/app/notifications.php?type=${type}`;
	const notification_category_active_class = getActivePageClass(notification_category_url);
	const last_notification = notifications?.at(-1);
	const timestamp = last_notification?.created_at;
	const notification_message = last_notification?.notification;

	const categoryElement = `
        <a href="${notification_category_url}" class="notification-category ${notification_category_active_class}" data-type="${type}" data-id="${id}">
            <div class="notification-category-info">
                <div class="notification-icon">
                <span class="material-symbols-rounded">${icon}</span>
                </div>
                <div class="notification-details">
                    <h2>${title}</h2>
                    ${last_notification ? `<p>${notification_message}</p>` : ''}
                </div>
            </div>
            <div class="notification-category-other-info">
                ${timestamp ? `<p class="notification-time">${getTimeDifference(timestamp)}</p>` : ''}
                ${notifications.length > 0 ? `<p class="notifications-count">${notifications.length}</p>` : ''}
            </div>
        </a>
      `;

	return categoryElement;
}

function displayNotificationCategoryList() {
	const notificationsList = document.getElementById('notification-category-list');

	if (notificationsList) {
		for (const category of notificationCategories) {
			const categoryElement = generateNotificationCategory(category);
			notificationsList.insertAdjacentHTML('beforeend', categoryElement);
		}
	}
}

async function fetchUserNotifications(userId) {
	return fetch(`${BASE_URL}/server/notifications.server.php?reason=get_user_notifications&user_id=${userId}`)
		.then((response) => response.json())
		.then((data) => {
			console.log(data);
			const { userNotifications, success } = data;

			if (success) {
				for (const notification of userNotifications) {
					for (const category of notificationCategories) {
						if (category.type === notification.notification_type) {
							category.notifications.push(notification);
							category.notification_count++;
						}
					}
				}
			}

			return userNotifications;
		});
}

function generateNotification(notification) {
	const {
		created_at,
		deleted_at,
		is_read,
		notification: content,
		notification_id,
		notification_type,
		updated_at,
		user_id,
	} = notification;

	const element = `
    <div class="notification" data-notification-id="${notification_id}">
        <p class="notification-content">${content}</p>
        <p class="notification-timestamp" title="${created_at}">${calculateElapsedTime(created_at)?.elapsedString}</p>
        <div class="actions-container"></div>
    </div>`;

	return element;
}

function generateCategoryNotificationsContainer(category) {
	const { id: categoryId, type, title, icon, notifications } = category;

	const notificationElements = notifications.map((notification) => generateNotification(notification)).join('\n');

	const element = `
    <div class="notification-category-header" data-notification-category-id="${categoryId}" data-notification-category-type="${type}">
        <span class="category-icon material-symbols-rounded-filled">${icon}</span>
        <div class="notification-category-info-container">
            <h2>${title}</h2>
        </div>
    </div>
    <div class="notifications-container" id="notifications-container">${notificationElements}</div>
    `;

	return element;
}

function displayCategoryNotificationsContainer(categoryType) {
	const notificationsContainer = document.getElementById('notifications-in-category-container');

	if (notificationsContainer) {
		notificationsContainer.innerHTML = '';

		const category = notificationCategories.find((category) => category.type === categoryType);
		const categoryElement = generateCategoryNotificationsContainer(category);
		notificationsContainer.insertAdjacentHTML('beforeend', categoryElement);
	}
}
