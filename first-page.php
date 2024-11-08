<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Management System</title>
    <meta name="description" content="Manage and monitor print jobs with our efficient print management system.">
    <style>
    body{
     background-image: url('photo.jpg');
     background-size: cover;
     background-repeat: no-repeat;
     background-attachment: fixed;
     background-position: center;
    }
    header{
        text-align: center;
        margin-right:30px;  
        /* background: rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(500px);
    border: 0px solid rgba(255, 255, 255, 0.3); */
 
    }
    section{
        /* position: absolute; */
        /* top: 50%; */
        /* left: 50%; */
        /* transform: translate(-50%, -50%); */   
        display: flex;
        flex-direction: column;
        height: 200px;
        border-right-width: 50px; 
        margin-left: 10%;
        margin-right: 20%;
        justify-content: center;
        align-items: center;
        padding: 50px;
        
    }
    section h2{
        font-family: Arial, Helvetica, sans-serif;
        font-weight: 600;
        margin-left: 5%;
    }
    section ul{
        display: flex;
        flex-direction: column;
        row-gap: 20%;
        height: 300px;
    }
    section ul li{
        list-style: none;
        height: 30px;
        min-width: 400px;
        border: 4px solid rgb(247, 168, 181);
        box-shadow: 0px 1px rgb(229, 155, 168);
        border-radius: 20px;
        text-align: center;
        background-color: pink;
        
    }
    section ul li:hover{
        border: 4px solid rgb(255, 74, 104);
        box-shadow: 0px 1px rgb(255, 74, 104);
        border-radius: 20px;  
        background-color:  rgb(255, 74, 104);;
    }
    section ul li a{
        color: black;
        text-decoration: none;
        font-family: Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif;
        font-size: medium;
        gap: 20px;
        display: grid;
        place-items: center;
    }
    @media screen and (max-width: 768px) {
            section {
                margin: 1rem 5%;
                padding: 1rem;
            }

            section ul li {
                padding: 0.5rem;
                font-size: 0.9rem;
            }
        }

        @media screen and (max-width: 480px) {
            section {
                margin: 0.5rem 2%;
                padding: 0.5rem;
            }

            section h2 {
                font-size: 1.2rem;
            }

            section ul li {
                font-size: 0.8rem;
            }
        }        
    
    </style>
</head>
<body>
    <header>
        <h1 style="font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;">Print Management System</h1>
    </header>
    <section>
        <h2 style="font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;">LOGIN AS</h2>
        <ul>
            <li><a href="./login_admin.php" target="_self">Admin</a></li>
            <li><a href="./login_user.php" target="_self">User</a></li>
        </ul>
    </section>
</body>
</html>