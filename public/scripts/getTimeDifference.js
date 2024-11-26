function getTimeDifference(timeString) {
	const inputDate = new Date(timeString); // Parse the input time string
	const now = new Date(); // Get the current date and time

	// Calculate the time difference in milliseconds
	const timeDiff = now - inputDate;

	// Check if the difference is less than a day (in milliseconds)
	const oneDay = 24 * 60 * 60 * 1000; // Milliseconds in a day
	if (timeDiff < oneDay && inputDate.getDate() === now.getDate()) {
		// Format as hours and minutes, e.g., "3:00 PM"
		const hours = inputDate.getHours();
		const minutes = inputDate.getMinutes().toString().padStart(2, '0');
		const period = hours >= 12 ? 'PM' : 'AM';
		const formattedHours = hours % 12 || 12; // Convert to 12-hour format
		return `${formattedHours}:${minutes}${period}`;
	} else {
		// Format as day and month, e.g., "25 May"
		const day = inputDate.getDate();
		const month = inputDate.toLocaleString('default', { month: 'short' }); // Get short month name
		return `${day} ${month}`;
	}
}

export default getTimeDifference;
