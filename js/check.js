async function getcookie2() {
    try {
        const response = await fetch('backend/check.php');
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        const data = await response.json(); // Debugging line
        const { login_status } = data;

        // Check if login_status is a string and equals "false"
        if (login_status === "false") { // Debugging line
            document.getElementById('logout').click();
        }
    } catch (error) {
        console.error('There was a problem with the fetch operation:', error);
        document.getElementById('logout').click();
        // Redirect on error
    }
}
function getCookie(name) {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) return parts.pop().split(';').shift();
    return null;
}

// Redirect if cookie is missing
if (!getCookie("user_id")) {
    document.getElementById('login').click();
} else {
    getcookie2(); // Only call server if cookie exists
}
