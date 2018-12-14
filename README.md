# word unscrambler php script

### usage
- command: `php zwwf.php [scrambled letters] [dictionary file]`

### examples
- `php zwwf.php abcd wordsEn.txt` *basic example*
- `php zwwf.php abcd < words_alpha.txt` *flush txt file in as stdin*
- `php zwwf.php xyz* wordlist` *use the astrisk as wildcard*
- `php zwwf.php foobar` *enter in your own words at runtime, use EOF to exit*

### misc
- a few dictionary text files are included, but you can use any others that you want
- the "wildcard" letter is a representation of "any letter", so when unscrambling the script will attempt to use any alphabetic char, a-z
