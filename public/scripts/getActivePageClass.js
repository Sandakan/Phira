function getActivePageClass(url) {
	const currentUrl = window.location.href.replace(window.location.origin, '');
	const matchingUrl = new URL(url);
	const strippedMatchingUrl = matchingUrl.href.replace(matchingUrl.origin, '');

	return currentUrl.includes(strippedMatchingUrl) ? 'active' : 'not-active';
}

export default getActivePageClass;
