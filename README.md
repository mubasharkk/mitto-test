#MITTO AG – SW Development assignment


#1) PHP / HTML

Write a PHP script reading all files from the temporary directory and creates an output the file list as HTML document.

The following requirements must be met:

*a)*  Sort the file list by filenames ascending in natural sort order, but show directories before files.
*b)*  Output the file list as HTML table with the following columns:
	- File name
	- File size (in KB)
	- Modification time (Format: YYYY-MM-DD HH:MM:SS)
	- Name of the owner
	- Name of the group
	- File permissions (unix notation, eg. drwxrwxrwx)
	- Age of the file (number of days)
	- A download button

*c)*  Add an error check (handler) able to catch all errors, warnings and notices.
*d)* Write code that prevents the occurring of any error warning or notice.
*e)*  Highlight table rows at mouse over using a fade effect, do this with pure CSS.
*f)*  Double clicking a table row toggles the font-weight (normal/bold) of that row.
*g)*  Write clear structured source code.
*h)* Add comments to your source code.


#2) Regular expressions

Write a PHP script that extract the name/http-equiv and content attribute of all meta-tags of an html document using a regular expression method. Save the result in an array.

Example:

If a HTML document contains the following metatags:

<meta http-equiv="content-type" content="text/html; charset=UTF-8" /> 
<meta name="keywords" content="Regular expression exercise" /> 

The result should look like:
<code>
Array ( 
	'content-type'	=> 'text/html; charset=UTF-8', 
	'keywords'		=> 'Regular expression exercise' 
)
</code>


# MySQL

Create MySQL code:

*a)*  Design a small MySQL database containing the following tables:

users (columns: userId, groupId, userName, userEmail) 
usergroups (columns: groupId, groupName)

*b)*  Add primary keys and indexes to the tables.
*c)*  Add 3 records to the usergroup table (groupNames: admin, employee, customer)
*d)* Add 6 records to the user table. Associate one user with the group admin, two users with the group employee, and 3 users with the group customer.
*e)*  Write a SELECT query that produces a user list with the following columns: userId, userName, userEmail, groupName.
*f)*  Write a SELECT query that lists all users being in the group admin or employee.
*g)*  Write a SELECT query that lists all usergroups. Columns: groupName, the count of users in the group, a comma-separated list of usernames.


