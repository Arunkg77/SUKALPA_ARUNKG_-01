document.getElementById('loginForm').addEventListener('submit', function(event) {
    event.preventDefault();

    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;

    // Basic authentication simulation
    if (username === 'arun' && password === '1234') {
        localStorage.setItem('isLoggedIn', true);
        localStorage.setItem('username', username);
        alert('Login successful!');
        
        // Redirect to a service page
        window.location.href = 'index.html';
    } else {
        alert('Invalid credentials');
    }
});

// Check if the user is already logged in
if (localStorage.getItem('isLoggedIn')) {
    window.location.href = 'indx.html';
}
