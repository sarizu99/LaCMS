# LaCMS Setup Guide
install vendors packages
```
composer install
```
install node modules
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
# Credits
- Samsul Arif Zulvian
- Chaerul Hadad
- Bayu Laksono Wahyu Arminsyah
