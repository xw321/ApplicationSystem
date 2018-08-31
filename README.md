# ApplicationSystem

This is a PHP project that simulates a college application system.


For this project, I created an application that allows students to apply 
to a set of classes. Students will go online and fill out an application 
where they will provide name, e-mail, current school year and additional 
information related to the class they would like to apply for. The 
application will also provide options (e.g., displaying current applicants, 
submitting an SQL query against the database) for the administrator of the 
application system.

The main features of this system are:

 - Submit Application

    - An applicant's name, e-mail, gpa, year 
                    (value between 10 and 12), gender and password will be read through a 
                    form.
                    
 - Review Application
 
   - Allows an applicant to see his/her 
                    application information.&nbsp; A form will request the applicant's email 
                    and password and your application will display the information available 
                    on the database. See the Sample section for the 
                    form and web page contents to use.
                    
                    
 - Update Application
 
   - Allows an applicant to update the 
                    information present in the database. A form will request the applicant's 
                    email and password and your application will display a form with the 
                    current information on the database.The user will be able to 
                    update the information through that form. See the
                    Sample section for the form and web page contents 
                    to use.
                   
                    
                    
                    
                    
                    
                    
- Administrative  

   - Allows a system administrator to display 
                    information about applicants. The administrator can select which fields 
                    (e.g., name, gpa, etc.) to display, which field to sort the data by and 
                    an optional filter condition (e.g., gpa > 3.0). The administrative task 
                    is password protected using authentication via the header function; use "main" as user name and "terps" 
                    as password.&nbsp; Your user name and password information must be 
                    encrypted. See the Sample section for the form and web page contents to use.
                                     
                    
                    
                    
The main page looks like this:


![Main page](/img/main.png)
