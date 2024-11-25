const calculateElapsed = (currentDateInMs, elapsedDateInMs) => {
	if (currentDateInMs && elapsedDateInMs) {
		const isFuture = elapsedDateInMs > currentDateInMs;
		const milliseconds = Math.abs(currentDateInMs - elapsedDateInMs);

		const elapsedSeconds = Math.floor(milliseconds / 1000);
		const elapsedMinutes = Math.floor(milliseconds / (1000 * 60));
		const elapsedHours = Math.floor(milliseconds / (1000 * 60 * 60));
		const elapsedDays = Math.floor(milliseconds / (1000 * 60 * 60 * 24));
		const elapsedMonths = Math.floor(milliseconds / (1000 * 60 * 60 * 24 * 30));
		const elapsedYears = Math.floor(milliseconds / (1000 * 60 * 60 * 24 * 30 * 12));

		if (elapsedSeconds < 60)
			return {
				elapsed: elapsedSeconds,
				type: 'second',
				isFuture,
				elapsedString: `${elapsedSeconds} seconds ago`,
			};
		if (elapsedMinutes < 60)
			return {
				elapsed: elapsedMinutes,
				type: 'minute',
				isFuture,
				elapsedString: `${elapsedMinutes} minutes ago`,
			};
		if (elapsedHours < 24)
			return {
				elapsed: elapsedHours,
				type: 'hour',
				isFuture,
				elapsedString: `${elapsedHours} hours ago`,
			};
		if (elapsedDays < 30)
			return {
				elapsed: elapsedDays,
				type: 'day',
				isFuture,
				elapsedString: `${elapsedDays} days ago`,
			};
		if (elapsedMonths < 12)
			return {
				elapsed: elapsedMonths,
				type: 'month',
				isFuture,
				elapsedString: `${elapsedMonths} months ago`,
			};
		if (elapsedYears > 0)
			return {
				elapsed: elapsedYears,
				type: 'year',
				isFuture,
				elapsedString: `${elapsedYears} years ago`,
			};
	}
	return undefined;
};

const calculateElapsedTime = (dateString, currDateString = new Date().toUTCString()) => {
	const currentDate = Date.parse(currDateString);
	const elapsedDate = Date.parse(dateString);

	return calculateElapsed(currentDate, elapsedDate);
};

export default calculateElapsedTime;
