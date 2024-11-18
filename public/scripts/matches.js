let matches = [];

const loader = document.getElementById('loader');
const body = document.getElementById('body');
const main = document.getElementById('main');
const noPermissionsAlert = document.getElementById('no-location-permissions-alert');
const matchesContainer = document.getElementById('matches');

document.addEventListener('DOMContentLoaded', () => {
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

				getMatches(BASE_URL, user_id, latitude, longitude);
			},
			(error) => {
				loader?.classList.add('hidden');
				noPermissionsAlert.classList.remove('hidden');
			}
		);
	}
});

function getMatches(BASE_URL, user_id, latitude, longitude) {
	fetch(
		`${BASE_URL}/server/matchmaking.server.php?reason=get_matches&user_id=${user_id}&latitude=${latitude}&longitude=${longitude}`,
		{
			method: 'GET',
		}
	)
		.then((res) => res.json())
		.then((res) => {
			loader?.classList.add('hidden');
			console.log(res);

			matches = res.map((user) => generateMatchElement(user_id, user, BASE_URL));
			showNextAvailableMatch();
		});
}

function generateMatchElement(user_id, match, BASE_URL) {
	const { user_id: match_user_id, first_name, last_name, gender, age, distance_km, preferences, biography } = match;

	const profile_picture_url = match.profile_picture_url
		? `${BASE_URL}/private/media/user_photos/${match.profile_picture_url}`
		: `${BASE_URL}/private/media/user_photos/3.jpg`;
	const all_photos =
		Array.isArray(match.all_photos) && match.all_photos.length > 0
			? match.all_photos.map((photo) => `${BASE_URL}/private/media/user_photos/${photo}`)
			: [
					`${BASE_URL}/private/media/user_photos/1.jpg`,
					`${BASE_URL}/private/media/user_photos/2.jpg`,
					`${BASE_URL}/private/media/user_photos/1.jpg`,
					`${BASE_URL}/private/media/user_photos/2.jpg`,
			  ];

	const photoElements = all_photos.map((photo) => {
		const photoElement = `<img class="photo" src="${photo}" alt="Temp Match">`;
		return photoElement;
	});

	matchElement = `
	            <div class="match">
                <div class="match-banner">
                    <img src="${profile_picture_url}" alt="${first_name} ${last_name} profile picture">
                    <div class="match-banner-data">
                        <div class="primary-data">
                            <h1 class="match-name">${first_name}</h1>
                            <h3 class="match-age">${age}</h3>
                        </div>
                        <div class="secondary-data">
                            <span class="match-location"><span class="material-symbols-rounded">distance</span></span>
                            <span class="match-distance">${roundTo(distance_km)} km away</span>
                        </div>
                    </div>
                </div>
                <div class="match-info">
                    <div class="other-photos">
						${photoElements.join('')}
                    </div>
                    <p class="match-bio">
						${biography}
                    </p>
                    <div class="match-preferences">
                        <div class="match-preference location-preference">
                            <span class="match-preference-icon-container">
                                <span class="material-symbols-rounded">distance</span>
                            </span>
                            <span class="match-preference-text"><b>${roundTo(distance_km)}</b> km away</span>
                        </div>
						<div class="match-preference birthday-preference">
							<span class="match-preference-icon-container">
								<span class="material-symbols-rounded">cake</span>
							</span>
							<span class="match-preference-text"><b>${age}</b> years old</span>
						</div>
						<div class="match-preference gender-preference">
							<span class="match-preference-icon-container">
								<span class="material-symbols-rounded">${gender.toLowerCase()}</span>
							</span>
							<span class="match-preference-text"><b>${gender}</b></span>
						</div>
                        <div class="match-preference partner-preference">
                            <span class="match-preference-icon-container">
                                <span class="material-symbols-rounded">digital_wellbeing</span>
                            </span>
                            <span class="match-preference-text">Looking for a <b>long-time partner</b></span>
                        </div>
                    </div>
                    <div class="match-actions-container">
                        <button class="btn btn-primary dislike-btn" onclick="dislikeMatch(${user_id},${match_user_id}, '${BASE_URL}')">
                            <span class="btn-icon material-symbols-rounded-filled">heart_broken</span> Dislike</button>
                        <button class="btn btn-primary like-btn" onclick="likeMatch(${user_id},${match_user_id}, '${BASE_URL}')"><span class="btn-icon material-symbols-rounded-filled">favorite</span> Like</button>
                    </div>
                </div>
            </div>
	`;

	return { match_id: match_user_id, element: matchElement };
}

function reload() {
	window.location.reload();
}

function roundTo(value, decimalPlaces = 1) {
	if (decimalPlaces === 0) return value;

	const pow = 10 ** decimalPlaces;
	const val = parseFloat((value * pow).toFixed(decimalPlaces - 1));
	return parseFloat((Math.round(val) / pow).toFixed(decimalPlaces)) * 1;
}

function showNextAvailableMatch() {
	if (matches.length > 0) {
		const match = matches.shift();
		matchesContainer.innerHTML = match.element;
	} else matchesContainer.innerHTML = '';
}

async function setMatchInteractionStatus(user_id, match_user_id, status, BASE_URL) {
	const res = await fetch(`${BASE_URL}/server/matchmaking.server.php`, {
		method: 'POST',
		headers: {
			'Content-Type': 'application/x-www-form-urlencoded',
		},
		body: `reason=add_match_interaction_status&user_id=${user_id}&match_user_id=${match_user_id}&status=${status}`,
	});
	return await res.json();
}

function likeMatch(user_id, match_id, BASE_URL) {
	setMatchInteractionStatus(user_id, match_id, 'LIKED', BASE_URL)
		.then(() => {
			matches = matches.filter((match) => match.user_id !== match_id);
			showNextAvailableMatch();
		})
		.catch(() => alert('Failed to like match.'));
}

function dislikeMatch(user_id, match_id, BASE_URL) {
	setMatchInteractionStatus(user_id, match_id, 'REJECTED', BASE_URL)
		.then(() => {
			matches = matches.filter((match) => match.user_id !== match_id);
			showNextAvailableMatch();
		})
		.catch(() => alert('Failed to dislike match.'));
}
