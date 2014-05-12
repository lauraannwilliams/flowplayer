README:

To install this script

1.) Create a mysql database to receive the records

2.) Apply db_create.sql to the database to create the video_views table

3.) Update the config.php file with your database connection credentials

4.) Place the html and php files in a web accessable directory on your virtual host

About this script

Two version of the html file have been provided.  Both include two videos to demonstrate the re-usability of the scripts.

"index.html" is a stripped down version of the assignment, with no feedback provided to the user. 

"debug.html" has a variety of additional information displayed, including a success/failure message for the ajax call. 
The success message also displays the number of matching records in the db

I have marked in comments places where the code could be upgraded to provide additional functionality and improved reusability.