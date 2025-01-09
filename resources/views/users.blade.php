{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>
</head>
<body>
    <h1>User List</h1>
    <ul id="user-list"></ul>

    <script>
        // Fetch data from your API
        async function fetchUsers() {
            try {
                const response = await fetch("http://127.0.0.1:8000/api/get-user"); // Update with your API URL
                const data = await response.json();
                const userList = document.getElementById("user-list");

                if (data.status) {
                    // Loop through users and display them
                    data.data.forEach(user => {
                        const li = document.createElement("li");
                        li.textContent = `${user.name} - ${user.email}`;
                        userList.appendChild(li);
                    });
                } else {
                    userList.innerHTML = `<li>${data.message}</li>`;
                }
            } catch (error) {
                console.error("Error fetching users:", error);
            }
        }

        // Fetch users on page load
        window.onload = fetchUsers;
    </script>
</body>
</html> --}}

<body>
    <h1>User List</h1>
    <ul>
        @foreach ($users as $user)
            <li>{{ $user->name }} - {{ $user->email }}</li>
        @endforeach
    </ul>
</body>

