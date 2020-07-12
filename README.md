# TeraBytes Warehouse

This repo contains the files for a project that is a significantly redesigned version of the Udemy course:
> E-Commerce Website in PHP and MySQL From Scratch" by Abdul Wali

The TeraBytes Warehouse (on-line tech products site) project is an exercise in creating a desk-top, ecommerce application using HTML, CSS, JavaScript, Apache 2.4; php v7.3.5 and MySQL v5.7. This is
a small, developmental site but it does demonstrate a fair degree of functionality that could prove
useful in work on a larger production application.

This repo contains my most recent version of this website.

## Some features

- The project has been pre-populated with data for easy testing
- The Administrative area must be accessed directly: eg /TeraBytes/admin_area/login.php
    A pre-populated administrator is: username:jsmart password:smart10
- Only administrators can add, edit or delete products, brands & categories
- Use your own server credentials in the MySqlConnector connector string
- Use your own email credentials in the phpmailer sections
- A paginator class is included to properly display larger result-sets
- Some simple client-side & server-side validation of form inputs is performed
- jQuery used to add some effects and event handling
- The database utilizes a price history table populated by a trigger when a product is edited
    This allows for non-static product pricing & accurate historical customer order pricing data
- Database views and stored procedures are used to greatly simplify programmatic coding
- With the exception of a customer's cart, deletes result in a change in status to "inactive"
    This preserves data in the database rather than deleting it entirely
- Expedited shipping charges & alternative shipping names/addresses are permitted & preserved
- phpmailer can be installed using several different methods; in my case I added it using
  Composer which was included in my root folder for Apache server. If you are using gmail
  for your account you many need to enable "less secure apps" access

In addition I used the following resources in my development process:

- Gimp 2.10 for image importing/manipulation and banner creation
- TINYMCE to create a rich text-editor for product adding/editing
- Database Schema Designer (DBSD) to create, design and test the database
- MySQL Workbench v8.0 for database execution & scripting
