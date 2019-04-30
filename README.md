# What is LaCMS?
LaCMS is a Content Management System which is built with laravel framework. LaCMS made by Samsul Arif Zulvian for the purpose of coursework in Singaperbangsa University.

# LaCMS Setup Guide
Clone this repository
```
git clone https://github.com/sarizu99/LaCMS.git
```
Install vendor packages
```
cd LaCMS
composer install
```
Install node modules
```
cd public
npm install
```
Make sure to add the following function in your database in order to make the snippet works properly
```
CREATE FUNCTION `strip_tags`($str text) RETURNS text
BEGIN
    DECLARE $start, $end INT DEFAULT 1;
    LOOP
        SET $start = LOCATE("<", $str, $start);
        IF (!$start) THEN RETURN $str; END IF;
        SET $end = LOCATE(">", $str, $start);
        IF (!$end) THEN SET $end = $start; END IF;
        SET $str = INSERT($str, $start, $end - $start + 1, "");
    END LOOP;
END;
```
# Bug Report
If you've found a bug in this project please email me at sarizu99@gmail.com.

# Credits
- Chaerul Hadad
- Bayu Laksono Wahyu Arminsyah
