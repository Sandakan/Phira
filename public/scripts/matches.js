const loader = document.getElementById('loader');

document.addEventListener('DOMContentLoaded', () => {
	const body = document.getElementById('body');
	const main = document.getElementById('main');
	const noPermissionsAlert = document.getElementById('no-location-permissions-alert');
	const matchesContainer = document.getElementById('matches');

	const BASE_URL = body.dataset.baseUrl;
	const user_id = body.dataset.userId;

	if (!user_id || !BASE_URL) return alert('User ID or Base URL not found.');

	if (navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(
			(position) => {
				noPermissionsAlert.classList.add('hidden');
				matchesContainer.classList.remove('hidden');

				const latitude = position.coords.latitude;
				const longitude = position.coords.longitude;
				console.log('Latitude:', latitude);
				console.log('Longitude:', longitude);

				getMatches(BASE_URL, user_id);
			},
			(error) => {
				loader?.classList.add('hidden');
				noPermissionsAlert.classList.remove('hidden');
			}
		);
	}
});

function getMatches(BASE_URL, user_id) {
	fetch(`${BASE_URL}/server/matchmaking.server.php?reason=get_matches&user_id=${user_id}`, {
		method: 'GET',
	})
		.then((res) => res.json())
		.then((res) => {
			loader?.classList.add('hidden');
			console.log(res);
		});
}

function reload() {
	window.location.reload();
}
