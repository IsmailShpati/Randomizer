# Randomizer
A simple and fun php project connected to a couple of API's that generate random stuff.
The main architecture of the project is that it is seperated in two parts, the public and application. The public contains the the main php page(<i>index.php</i>) which initiates the init.php which performs the database connection and reloads all Eloquent models, used to communicate with the database. It also constructs the App class which is the router of the whole application that does the parsing of the url's and redirection to controllers and views. The logic for user restriction when not logged in is in this file application/core/App.php. There is also an abstract Controller class which every other controller extends in order to browse the views freely. Each controller class is required to override the index method which is used when the controller is first invoked.  

#
# Login Page
The project is made out of 4 main pages plus the login and register page. 
Every user can't access the other pages without logging in.
![image](https://user-images.githubusercontent.com/75791043/156818343-705aecbb-caff-4026-b79d-1dbce61da021.png)
An error message is shown when the user credentials don't match the ones in the database. To validate the credentials, a SELECT query is performed in the database to fetch users with that user name. If no records fetched then the error is raised. If a record is fetched and the user password doesn't match the encrypted password in the database, then another error message is raised notifying for invalid password.
![image](https://user-images.githubusercontent.com/75791043/156818586-3b581dd4-c4d2-427b-83d9-774052730700.png)

#
# Register Page 
Register page is also very similar, with the adition of regexp testing of the password which should contain the famous 1 upper case, 1 lower case, 1 digit, 1 special character and a minimum length of 8. To validate that a user doesn't exist with that user name a SELECT query is also performed for that user name. If the query returns a record then an error is raised since two users can't have the same username. Else the user is given a unique id create by uniqid() (gets time in macroseconds) function of php with the prefix of session id to ensure no two users generate the same password at the given time. Then the user password is encrypted using password_hash() method.
![image](https://user-images.githubusercontent.com/75791043/156827360-9c62f923-3a32-4fea-acc1-1bce79a1b489.png)

#
# Home Page 
After a succesful login the user id and user name are stored in the SESSION including the authorization flag. The user is redirected to the home page, which shows random fact of the day and a table of all the api requests the user has done. More on that later. The user can also delete records from the database by clicking the X button on the left of the record. A DELETE request is initiated using AJAX from javascript, when the button is clicked. 
![image](https://user-images.githubusercontent.com/75791043/156818028-0004b42a-1822-457d-97cf-3b101299e969.png)
![image](https://user-images.githubusercontent.com/75791043/156828486-03a8f171-abd3-40c5-aef8-91ba03a11233.png)

#
# Random Data Page
Then we have the Data page which generates random data. Contributes to <a href="https://random-data-api.com/documentation">Random Data Api</a>. This endpoint fetches some of the available api endpoints that i have added: Random Name, Random Address and Random Vehicle. Once the Generate button is clicked with one of the collections, a GET request is performed on the respective endpoint and response body is then parsed, into html  while beautifing and adding colors to the tags and values based on their type (brown for keys, green for string and blue for numbers).
![image](https://user-images.githubusercontent.com/75791043/156829116-92b91264-b9b6-4598-a905-16c8e2464e73.png)
![image](https://user-images.githubusercontent.com/75791043/156829192-d21ea910-f310-417d-a5f3-b062efe0e8f8.png)

#
# Random Meals Page
The third page is my favourite one. Random meal generator. Contributes to <a href="https://www.themealdb.com">Random Meal Api</a>. Similar to above, a GET request is performed using Guzzle http library. The json response body is than parsed into html, the title, the country of origin, the image, the instructions and everything is fetched from the json and parsed into the html body that is displayed on screen.
![image](https://user-images.githubusercontent.com/75791043/156829325-ffa17755-80e0-4baf-94de-21c9e39fd53c.png)
![image](https://user-images.githubusercontent.com/75791043/156829381-23178413-29a6-469c-97f5-08a6db68f119.png)
![image](https://user-images.githubusercontent.com/75791043/156829407-fa441514-1d70-4c24-b414-5d03a78adacd.png)

#
# Log Out
The last "page" is the logout button which logs the user out by removing every custom data stored in the SESSION including the authorizaion redirecting the user to the log in page.
![image](https://user-images.githubusercontent.com/75791043/156829812-efa83ab5-e679-4558-904f-92827b6cabe0.png)

![image](https://user-images.githubusercontent.com/75791043/156829688-df043c7e-d6b1-47a6-901e-63fa86b1469c.png)

#
# Importing and configuring the project
1. In order to do so make sure you have XAMPP or any other version of AMPP compatible with your system. Make sure to have apache installed and configured in php.init file in the XAMPP directory. 
1. Copy the Randomizer project folder into  [your path to xampp]/Xampp/htdocs and after this step the project path must look something like this<br>
|--[Your path to Xampp folder]<br>
---|__Xampp<br>
------|__htdocs<br>
---------|__Randomizer<br>
------------|__application<br>
------------|__public<br>
1. After this step, go inside Randomizer\application\database.php and change database properties under $capsule->addConnection(){...}. My database of choice was Postgres but you can use whatever database you want as long as you change the driver to the appropriate one. 
1. Make sure to have Composer installed in your computer as it is needed to import Guzzle and Eloquent libraries from the central
1. Once everything is finished boot up Xampp apache server and go to http:localhost//Randomizer/public/home which will take you to the log/register page. 
1. If any problem arises feel free to contact me by email at ismailshpati@gmail.com.

# Enjoy the project.

