<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="stylingfile/maindisplay.css">
    <link rel="icon" href="iconlogo/bunniwinkleIcon.ico">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Management</title>
    <style>
        body {
            background: rgb(238,174,202);
            background: radial-gradient(circle, rgba(238,174,202,1) 0%, rgba(148,187,233,1) 100%);
            font-family: "Trebuchet MS", "Lucida Sans Unicode", "Lucida Grande", "Lucida Sans", Arial, sans-serif;
        }

        .managementContainer {
            display: inline-block;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            align-items: center;
            border: solid 2px;
            border-radius: 8px;
            box-shadow: 0 0 6px rgba(0, 0, 0, 0.5);
            width: 80%;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.7);
            text-align: center;
        }

        .searchBar {
            width: 60%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
            margin-bottom: 10px;
        }

        .tableContainer table {
            width: 100%;
            border-collapse: collapse;
        }

        .tableContainer th, .tableContainer td {
            padding: 10px;
            border: 1px solid #ccc;
        }

        .actionButton {
            border-radius: 10px;
            background-color: pink;
            border: none;
            padding: 6px;
            font-size: 16px;
            margin: 5px;
            transition: background-color 0.3s ease, transform 0.3s ease, box-shadow 0.3s;
            cursor: pointer;
        }

        .actionButton:hover {
            background-color: hotpink;
            box-shadow: 0 0 6px rgba(184, 112, 112, 1);
            transform: scale(1.1);
        }
    </style>
</head>

<body>
    <div class="managementContainer">
        <h2>Account Management</h2>
        <p>Manage user roles, credentials, and permissions.</p>
        <input type="text" class="searchBar" placeholder="Search for an account (Username, Email, Contact)...">
        <div class="tableContainer">
            <table>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Contact</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
                <tr>
                    <td>1</td>
                    <td>BunniwinklePulilan</td>
                    <td>BunniwinklePulilan@gmail.com</td>
                    <td>+1234567890</td>
                    <td>Admin</td>
                    <td>
                        <button class="actionButton">Edit</button>
                        <button class="actionButton">Delete</button>
                        <button class="actionButton">Suspend</button>
                        <button class="actionButton">Reset Password</button>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Jane</td>
                    <td>Jane@gmail.com</td>
                    <td>+0987654321</td>
                    <td>Staff</td>
                    <td>
                        <button class="actionButton">Edit</button>
                        <button class="actionButton">Delete</button>
                        <button class="actionButton">Suspend</button>
                        <button class="actionButton">Reset Password</button>
                    </td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Jame</td>
                    <td>Jame@gmail.com</td>
                    <td>+1122334455</td>
                    <td>Brand Partner</td>
                    <td>
                        <button class="actionButton">Edit</button>
                        <button class="actionButton">Delete</button>
                        <button class="actionButton">Suspend</button>
                        <button class="actionButton">Reset Password</button>
                    </td>
                </tr>
            </table>
        </div>
        <h3>Owner Actions</h3>
        <p>Create, edit, or suspend user accounts.</p>
        <p>Assign roles to Staff, Brand Partners, and other users.</p>
        <p>Reset passwords or deactivate accounts.</p>
    </div>
</body>
</html>