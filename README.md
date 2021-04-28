# AWS-EC2-instance-web-application
Create a simple online music subscription application using PHP, S3 and DynamoDB and host it in a free-tier EC2 instance (with Ubuntu Server 20.04/18.04 LTS AMI)which will have following components and functions:


## DynamoDB: 
1.1. Create a “login” table in DynamoDB which will have email, password and username. 

1.2. Write a program to automatically create a “music” table in DynamoDB with the following attributes.
title, artist, year, web_url, image_url

1.3. Write a program to automatically load the data from a2.json to your music table.

2. Write a program to automatically download all the artist images according to the image_url values in a2.json and upload the images into S3.

## login page
The login page contains an “Email” text field, a “Password” field, and a “Login” button as well as a register link. When user clicks the “Login” button, it will validate if the user entered credentials match with the information stored in the login table.

3.1. If the user credential is invalid, the login page will display “email or password is invalid”. 

3.2. If the user credential is valid, it will be redirected to the main page.

## register page
The register page contains an “Email” text field, a “Username” a “Password” field, and a “Register” button. When a user clicks the “Register” button, it will validate if the user entered email matches with the email stored in the login table.

4.1. If the entered email matches with the email stored in the login table, the register page will show “The email already exists”. 

4.2. If the entered email is unique,

4.2.1. the new user information will be stored in the login table, and

4.2.2. the user will be redirected to the login page, where user can login with the new email and password.

## main page
The main page contains three main areas: a user area, a subscription area, a query area and a “Logout” link.

5.1. After a user logs in, the user area will show the corresponding user_name.

### The subscription area

5.2.1. The subscription area will show all the user subscribed music information (title, artist, and year) stored in DynamoDB.

5.2.2. Each music information is followed by the corresponding artist image retrieved from S3 and a “Remove” button. 

5.2.3. If the user clicks a “Remove” button, the corresponding subscribed music information and artist information will be removed from the subscription area and the corresponding table in DynamoDB.

### Query area

5.3. The query area should contain three text areas, “Title”, “Year”, “Artist” and a “Query” button. Once the user enters some information in any (or all) these text areas and clicks the “Query” button,

5.3.1. If the queried information is not contained in the entities’ corresponding attribute value(s) in the music table, it will show “No result is retrieved. Please query again”.

5.3.2. If the queried information is contained in (one or more) entities’ corresponding attribute value(s) in the music table, the area will show

5.3.2.1. All the retrieved music information (title, artist, and year). 

5.3.2.2. Each music information is followed by the corresponding artist images retrieved from S3 and a “Subscribe” button.

5.3.2.3. If the user clicks a “Subscribe” button, the subscribed music information and the corresponding artist image will be added into the subscription area and the subscribed music information will be stored in DynamoDB.

5.4. If the user clicks the “Logout” link, the user will be redirected to the login page.
