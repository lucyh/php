<?php


# A Cutter code or Cutter number "is an alphanumeric device to code text so that it can be arranged in alphabetical order
# using the fewest characters. It contains one or two initial letters and Arabic numbers, treated as a decimal."
#  Reference https://en.wikipedia.org/wiki/Cutter_Expansive_Classification#Cutter_numbers_(Cutter_codes)

# Cutter Table:
# First Letter      |   2   |   3   |   4   |   5   |   6   |   7   |   8   |   9
# ==================|=======|=======|=======|=======|=======|=======|=======|=======
#  S                |   A   | Ch    | E     | HI    | MNOP  | T     | U     | WXYZ
#  Qu               |       | A     | E     | I     | O     | R     | T     | Y
#  other consonants |       | A     | E     | I     | O     | R     | U     | Y
#  vowels           | B     | D     | LM    | N     | P     | R     | ST    | UVWXY
#  other, 3+ letter |       | ABCD  | EFGH  | IJKL  | MNO   | PQRS  | TUV   | WXYZ
# ==================|=======|=======|=======|=======|=======|=======|=======|=======
# First Letter      |   2   |   3   |   4   |   5   |   6   |   7   |   8   |   9

$expected_codes = [ "AaAA, Aaaa" => "Aa33", "Abbott, Bud" => "A23", "Adams, Douglas" => "A33"
                  , "Dickens, Charles" => "D53", "Dickinson, Emily" => "D535", "King, Stephen" => "K56"
                  , "Kingsolver, Barbara" =>"K567", "MacLachlan, Patricia" => "Mac53", "McCarthy, Cormac" => "Mc33"
                  , "Orwell, George" => "O79", "Qian, John" => "Q53", "Quinn, Kate" => "Qu56"
                  , "Sachar, Louis" => "S23", "Schlink, Bernhard" => "S35", "Smith, Alice" => "S653"
                  , "Smith, Tom" => "S658", "Yi, Andrea Scalzo" => "Y5", "ZZZZZZZ, ZZZZZZZ" => "Z99"  ];

$generated_codes = [];

function write($text){
    echo "$text\n";
}

# <ul>
# <li>If {@code text1} is shorter than {@code text2} and {@code text2} starts with {@code text1}, return the length of {@code text1}
# <li>Otherwise, if {@code text2} is shorter than {@code text1} and {@code text1} starts with {@code text2}, return the length of {@code text2}
# <li>Otherwise, return the index where the characters at the position in {@code text1} and {@code text2} are not the same (starting at index 0, compare
# each index)
# 
# @param text1
#            a String representing some text
# @param text2
#            a String representing some other text
# @return an int representing the first character where the two Strings differ
/*    private int findFirstCharDiff( String text1, String text2 )
    {
        int retVal = -1;
        if( text1.length() < text2.length() && text2.startsWith( text1 ) )
        {
            retVal = text1.length();
        }
        else if( text2.length() < text1.length() && text1.startsWith( text2 ) )
        {
            retVal = text2.length();
        }
        else
        {
            int min = text1.length() < text2.length() ? text1.length() : text2.length();
            for( int i = 0; i <= min; i++ )
            {
                if( text1.charAt( i ) != text2.charAt( i ) )
                {
                    retVal = i;
                    break;
                }
            }
        }
        return retVal;
    }
*/

# Starting at index 1 (skipping first character since it will usually be capital), check each character in {@code text} to see if it is uppercase, return
# the index of the first uppercase character found (or -1 if none are found)
# @param text a String representing some text
# @return an int representing the first capital letter after the initial character
/*    private int findIdxCapitalLetter( String text )
    {
        int retVal = -1;
        // Skipping first character since it will usually be capital
        for( int i = 1; i < text.length(); i++ )
        {
            if( Character.isUpperCase( text.charAt( i ) ) )
            {
                retVal = i;
                break;
            }
        }
        return retVal;
    }
*/

# For each name in the $expected_codes:
# --Call generateCode() with the name to generate a Cutter code
# --If $generated_codes already contains the generated Cutter code
# ----Call handleDuplicate() with the current name, the name currently associated with the generated Cutter code in $generated_codes, and the generated Cutter code
# --Otherwise, call add the generated Cutter code-name pair to $generated_codes (call putGeneratedCode())
function generateAll() { // #TODO
    global $expected_codes, $generated_codes;
    foreach( $expected_codes as $name => $code ) {
        $generated_code = ""; #= generateCode( name );
        if( key_exists($generated_code, $generated_codes) ) {
            #handleDuplicate( name, generatedCodes.get( generatedCode ), generatedCode );
        } else {
            putGeneratedCode( $generated_code, $name );
        }
    }
}

# <ul>
# <li>The last name is the first element in the array resulting when {@code name} is split on a comma (<b>{@code ,}</b>)
# <li>The alphabetic part of the Cutter code is set to the first character of the last name
# <li>If the last name starts with {@code "Qu"}, then {@code "Qu"} should be used as the alphabetic part of the cutter code
# <li>Otherwise, if the result of calling {@link #findIdxCapitalLetter(String)} with the last name is greater than 0, the portion of the last name up to
# the capital letter should be the alphabetic part
# <li>The remaining text is the part in the last name after the alphabetic part
# <li>If the alphabetic part of the Cutter code is {@code "S"}, set the first number to the result of calling {@link #genForS(String)} with the remaining
# text
# <li>Otherwise, if it is {@code "Qu"}, set the first number to the result of calling {@link #genForQu(String)} with the remaining text
# <li>Otherwise, if it is a consonant other than {@code "S"}, set the first number to the result of calling {@link #genForOtherConsonants(String)} with the
# remaining text
# <li>Otherwise, if it is a vowel ({@code "A"}, {@code "E"}, {@code "I"}, {@code "O"}, or {@code "U"}), set the first number to the result of calling
# {@link #genForVowels(String)} with the remaining text
# <li>Otherwise, set the first number to the result of calling {@link #genForOtherOrThirdLetter(String)} with the remaining text
# <li>The first character is removed from the remaining text (or the first two if the last name starts with {@code "Sch"})
# <li>If there is anything left of the last name, set number 2 equal to {@link #genForOtherOrThirdLetter(String)} with the remaining text
# <li>Return a String consisting of the alphabetic part followed by number 1 and number 2 (if it is not <b>{@code null}</b>)
# 
# @param name
#            a String representing a name
# @return a String representing the generated Cutter code
/*    private String generateCode( String name )
    {
        String lastName = name.split( "," )[ 0 ];
        String alpha = lastName.substring( 0, 1 );
        if( lastName.toUpperCase().startsWith( "QU" ) )
        {
            alpha = "Qu";
        }
        else
        {
            int capitalLetterIdx = findIdxCapitalLetter( lastName );
            if( capitalLetterIdx > 0 )
            {
                alpha = lastName.substring( 0, capitalLetterIdx );
            }
        }
        String remaining = lastName.substring( alpha.length() );
        String nbr1 = null;
        switch( alpha )
        {
            case "S":
                nbr1 = genForS( remaining );
                break;
            case "Qu":
                nbr1 = genForQu( remaining );
                break;
            case "B":
            case "C":
            case "D":
            case "F":
            case "G":
            case "H":
            case "J":
            case "K":
            case "L":
            case "M":
            case "N":
            case "P":
            case "Q":
            case "R":
            case "T":
            case "V":
            case "W":
            case "X":
            case "Y":
            case "Z":
                nbr1 = genForOtherConsonants( remaining );
                break;
            case "A":
            case "E":
            case "I":
            case "O":
            case "U":
                nbr1 = genForVowels( remaining );
                break;
            default:
                nbr1 = genForOtherOrThirdLetter( remaining );
                break;
        }
        remaining = remaining.substring( remaining.length() >= 1 ? 1 : remaining.length() );
        if( lastName.toUpperCase().startsWith( "SCH" ) )
        {
            remaining = remaining.substring( 2 );
        }
        String nbr2 = remaining.length() > 0 ? genForOtherOrThirdLetter( remaining ) : null;
        return String.format( "%s%s%s", alpha, nbr1, nbr2 == null ? "" : nbr2 );
    }
*/

# <ul>
# <li>If the first character of {@code text} is {@code "A"}, return <b>{@code "3"}</b>
# <li>Otherwise, if it is {@code "E"}, return <b>{@code "4"}</b>
# <li>Otherwise, if it is {@code "I"}, return <b>{@code "5"}</b>
# <li>Otherwise, if it is {@code "O"}, return <b>{@code "6"}</b>
# <li>Otherwise, if it is {@code "R"}, return <b>{@code "7"}</b>
# <li>Otherwise, if it is {@code "U"}, return <b>{@code "8"}</b>
# <li>Otherwise, if it is {@code "Y"}, return <b>{@code "9"}</b>
# <li>Otherwise, return the result of calling {@link #genForOtherOrThirdLetter(String)} with {@code text}
# 
# @param text
#            a String representing some text
# @return a String representing the generated number
/*    private String genForOtherConsonants( String text )
    {
        String retVal = null;
        String firstChar = text.substring( 0, 1 );
        switch( firstChar.toUpperCase() )
        {
            case "A":
                retVal = "3";
                break;
            case "E":
                retVal = "4";
                break;
            case "I":
                retVal = "5";
                break;
            case "O":
                retVal = "6";
                break;
            case "R":
                retVal = "7";
                break;
            case "U":
                retVal = "8";
                break;
            case "Y":
                retVal = "9";
                break;
            default:
                retVal = genForOtherOrThirdLetter( text );
                break;
        }
        return retVal;
    }
*/

# <ul>
# <ul>
# <li>If the first character of {@code text} is {@code "A"}, {@code "B"}, {@code "C"}, or {@code "D"}, return <b>{@code "3"}</b>
# <li>Otherwise, if it is {@code "E"}, {@code "F"}, {@code "G"}, or {@code "H"}, return <b>{@code "4"}</b>
# <li>Otherwise, if it is {@code "I"}, {@code "J"}, {@code "K"}, or {@code "L"}, return <b>{@code "5"}</b>
# <li>Otherwise, if it is {@code "M"}, {@code "N"}, or {@code "O"}, return <b>{@code "6"}</b>
# <li>Otherwise, if it is {@code "P"}, {@code "Q"}, {@code "R"}, or {@code "S"}, return <b>{@code "7"}</b>
# <li>Otherwise, if it is {@code "T"}, {@code "U"}, or {@code "V"}, return <b>{@code "8"}</b>
# <li>Otherwise, if it is {@code "W"}, {@code "X"}, {@code "Y"}, or {@code "Z"}, return <b>{@code "9"}</b>
# <li>Otherwise, log an error
# 
# @param text
#            a String representing some text
# @return a String representing the generated number
/*    private String genForOtherOrThirdLetter( String text )
    {
        String retVal = null;
        String firstChar = text.substring( 0, 1 );
        switch( firstChar.toUpperCase() )
        {
            case "A":
            case "B":
            case "C":
            case "D":
                retVal = "3";
                break;
            case "E":
            case "F":
            case "G":
            case "H":
                retVal = "4";
                break;
            case "I":
            case "J":
            case "K":
            case "L":
                retVal = "5";
                break;
            case "M":
            case "N":
            case "O":
                retVal = "6";
                break;
            case "P":
            case "Q":
            case "R":
            case "S":
                retVal = "7";
                break;
            case "T":
            case "U":
            case "V":
                retVal = "8";
                break;
            case "W":
            case "X":
            case "Y":
            case "Z":
                retVal = "9";
                break;
            default:
                System.out.printf( "Error finding code for [%s] (remaining text [%s]).\n",
                    firstChar.toUpperCase(),
                    text );
                break;
        }
        return retVal;
    }
*/

# <ul>
# <li>If the first character of {@code text} is {@code "A"}, return <b>{@code "3"}</b>
# <li>Otherwise, if it is {@code "E"}, return <b>{@code "4"}</b>
# <li>Otherwise, if it is {@code "I"}, return <b>{@code "5"}</b>
# <li>Otherwise, if it is {@code "O"}, return <b>{@code "6"}</b>
# <li>Otherwise, if it is {@code "R"}, return <b>{@code "7"}</b>
# <li>Otherwise, if it is {@code "T"}, return <b>{@code "8"}</b>
# <li>Otherwise, if it is {@code "Y"}, return <b>{@code "9"}</b>
# <li>Otherwise, return the result of calling {@link #genForOtherOrThirdLetter(String)} with {@code text}
# 
# @param text
#            a String representing some text
# @return a String representing the generated number
/*    private String genForQu( String text )
    {
        String retVal = null;
        String firstChar = text.substring( 0, 1 );
        switch( firstChar.toUpperCase() )
        {
            case "A":
                retVal = "3";
                break;
            case "E":
                retVal = "4";
                break;
            case "I":
                retVal = "5";
                break;
            case "O":
                retVal = "6";
                break;
            case "R":
                retVal = "7";
                break;
            case "T":
                retVal = "8";
                break;
            case "Y":
                retVal = "9";
                break;
            default:
                retVal = genForOtherOrThirdLetter( text );
                break;
        }
        return retVal;
    }
*/

# <ul>
# <li>If the first character of {@code text} is {@code "A"}, return <b>{@code "2"}</b>
# <li>Otherwise, if it is {@code "C"}:
# <ul>
# <li>If the first two characters of {@code text} are {@code "CH"}, return <b>{@code "3"}</b>
# <li>Otherwise, return the result of calling {@link #genForOtherOrThirdLetter(String)} with {@code text}
# 
# <li>Otherwise, if it is {@code "E"}, return <b>{@code "4"}</b>
# <li>Otherwise, if it is {@code "H"} or {@code "I"}, return <b>{@code "5"}</b>
# <li>Otherwise, if it is {@code "M"}, {@code "N"}, {@code "O"}, or {@code "P"}, return <b>{@code "6"}</b>
# <li>Otherwise, if it is {@code "T"}, return <b>{@code "7"}</b>
# <li>Otherwise, if it is {@code "U"}, return <b>{@code "8"}</b>
# <li>Otherwise, if it is {@code "W"}, {@code "X"}, {@code "Y"}, or {@code "Z"}, return <b>{@code "9"}</b>
# <li>Otherwise, return the result of calling {@link #genForOtherOrThirdLetter(String)} with {@code text}
# 
# @param text
#            a String representing some text
# @return a String representing the generated number
/*    private String genForS( String text )
    {
        String retVal = null;
        String firstChar = text.substring( 0, 1 );
        switch( firstChar.toUpperCase() )
        {
            case "A":
                retVal = "2";
                break;
            case "C":
                retVal = text.substring( 0, 2 ).toUpperCase().equals( "CH" ) ? "3" : genForOtherOrThirdLetter( text );
                break;
            case "E":
                retVal = "4";
                break;
            case "H":
            case "I":
                retVal = "5";
                break;
            case "M":
            case "N":
            case "O":
            case "P":
                retVal = "6";
                break;
            case "T":
                retVal = "7";
                break;
            case "U":
                retVal = "8";
                break;
            case "W":
            case "X":
            case "Y":
            case "Z":
                retVal = "9";
                break;
            default:
                retVal = genForOtherOrThirdLetter( text );
                break;
        }
        return retVal;
    }
*/

# <ul>
# <li>If the first character of {@code text} is {@code "B"}, return <b>{@code "2"}</b>
# <li>Otherwise, if it is {@code "D"}, return <b>{@code "3"}</b>
# <li>Otherwise, if it is {@code "L"} or {@code "M"}, return <b>{@code "4"}</b>
# <li>Otherwise, if it is {@code "N"}, return <b>{@code "5"}</b>
# <li>Otherwise, if it is {@code "P"}, return <b>{@code "6"}</b>
# <li>Otherwise, if it is {@code "R"}, return <b>{@code "7"}</b>
# <li>Otherwise, if it is {@code "S"} or {@code "T"}, return <b>{@code "8"}</b>
# <li>Otherwise, if it is {@code "U"}, {@code "V"}, {@code "W"}, {@code "X"}, or {@code "Y"}, return <b>{@code "9"}</b>
# <li>Otherwise, return the result of calling {@link #genForOtherOrThirdLetter(String)} with {@code text}
# 
# @param text
#            a String representing some text
# @return a String representing the generated number
/*    private String genForVowels( String text )
    {
        String retVal = null;
        String firstChar = text.substring( 0, 1 );
        switch( firstChar.toUpperCase() )
        {
            case "B":
                retVal = "2";
                break;
            case "D":
                retVal = "3";
                break;
            case "L":
            case "M":
                retVal = "4";
                break;
            case "N":
                retVal = "5";
                break;
            case "P":
                retVal = "6";
                break;
            case "R":
                retVal = "7";
                break;
            case "S":
            case "T":
                retVal = "8";
                break;
            case "U":
            case "V":
            case "W":
            case "X":
            case "Y":
                retVal = "9";
                break;
            default:
                retVal = genForOtherOrThirdLetter( text );
                break;
        }
        return retVal;
    }
*/

# <ul>
# <li>Remove the {@code generatedCode} from $generated_codes
# <li>If the last name portion (part before the comma (<b>{@code ,}</b>)) of {@code name1} equals the last name portion of {@code name2}:
# <ul>
# <li><i>FIXME Should do something to handle case where there is no comma (<b>{@code ,}</b>)</i>
# <li><i>FIXME Also not appropriately handling case where first names start with same character or need to go into middle name, etc.</i>
# <li>Concatenate the result of calling {@link #genForOtherOrThirdLetter(String)} with the first name of {@code name1} (second element of the array
# resulting on splitting {@code name1} on a comma (<b>{@code ,}</b>)) to {@code generatedCode} and put it in $generated_codes with
# {@code name1}
# <li>Concatenate the result of calling {@link #genForOtherOrThirdLetter(String)} with the first name of {@code name2} to {@code generatedCode} and put it
# in $generated_codes with {@code name2}
# 
# <li>Otherwise:
# <ul>
# <li>Find the first different character between the two names using {@link #findFirstCharDiff(String, String)}
# <li>If the last name portion of {@code name1} comes lexicographically after the last name portion of {@code name2}:
# <ul>
# <li>Concatenate the result of calling {@link #genForOtherOrThirdLetter(String)} with the substring of the last name portion of {@code name1} starting at
# the first different character to {@code generatedCode} and put it in $generated_codes with {@code name1}
# <li>Put {@code generatedCode} in $generated_codes with {@code name2}
# 
# <li>Otherwise:
# <ul>
# <li>Put {@code generatedCode} in $generated_codes with {@code name1}
# <li>Concatenate the result of calling {@link #genForOtherOrThirdLetter(String)} with the substring of the last name portion of {@code name2} starting at
# the first different character to {@code generatedCode} and put it in $generated_codes with {@code name2}
# 
# 
# 
# @param name1
#            a String representing the first name
# @param name2
#            a String representing the second name
# @param generatedCode
#            a String representing the generated Cutter code
/*    private void handleDuplicate( String name1, String name2, String generatedCode )
    {
        System.out.printf( "Duplicate code [%s] generated for [%s] and [%s].\n", generatedCode, name1, name2 );
        generatedCodes.remove( generatedCode );
        String lastName1 = name1.split( "," )[ 0 ];
        String lastName2 = name2.split( "," )[ 0 ];
        if( lastName1.equals( lastName2 ) )
        {
            // FIXME Should do something to handle case where there is no comma
            String firstName1 = name1.split( "," )[ 1 ].trim();
            String firstName2 = name2.split( "," )[ 1 ].trim();
            // FIXME Also not appropriately handling case where first names start with same character or need to go into middle name, etc.
            putGeneratedCode( String.format( "%s%s", generatedCode, genForOtherOrThirdLetter( firstName1 ) ), name1 );
            putGeneratedCode( String.format( "%s%s", generatedCode, genForOtherOrThirdLetter( firstName2 ) ), name2 );
        }
        else
        {
            int charDiff = findFirstCharDiff( lastName1, lastName2 );
            if( lastName1.compareTo( lastName2 ) > 0 ) // Meaning lastName1 comes after lastName2
            {
                putGeneratedCode( String.format( "%s%s",
                        generatedCode,
                        genForOtherOrThirdLetter( lastName1.substring( charDiff ) ) ), name1 );
                putGeneratedCode( generatedCode, name2 );
            }
            else
            {
                putGeneratedCode( generatedCode, name1 );
                putGeneratedCode( String.format( "%s%s",
                        generatedCode,
                        genForOtherOrThirdLetter( lastName2.substring( charDiff ) ) ), name2 );
            }
        }
    }
*/

# If $generated_codes contains $code and the value of the key $code in $generated_codes is not equal to $name, log a message
# Put the key-value pair, $code-$name in $generated_codes
# $code: a String representing the generated Cutter code
# $name: a String representing the name
function putGeneratedCode( $code, $name ) {
    global $generated_codes;
    if( key_exists($code, $generated_codes) && $generated_codes[$code] !==$name ){
        write( "Generated code [$code] for [$generated_codes[$code] is being replaced with [$name].");
    }
    $generated_codes[$code] = $name;
}

# Call {@link #generateAll()} to generate Cutter codes for all names in $expected_codes
# If the number of generated Cutter codes in $generated_codes does not match the number in $expected_codes, log a message
# For each generated Cutter code-name pair in $generated_codes, log a message indicating if the generated Cutter code matches the expected code
# If any names were included in $expected_codes but not found in $generated_codes, log a message for each
write("Start generating Cutter codes");
write( "==================================================" );
generateAll();
if( sizeof($expected_codes) !== sizeof($generated_codes) ){
    write( "Expected to generate [".sizeof($expected_codes)."] codes but generated [".sizeof($generated_codes)."].");
    write( "==================================================" );
}
/*        Set<String> expdNameSet = new HashSet<String>( expectedCodes.keySet() );
        for( Entry<String, String> e : $generated_codes.entrySet() )
        {
            String name = e.getValue();
            expdNameSet.remove( name );
            boolean codesMatch = e.getKey().equals( expectedCodes.get( name ) );
            System.out.printf( "%sFor [%s], generated code [%s]%s.\n",
                codesMatch ? "" : "ERROR: ",
                name,
                e.getKey(),
                codesMatch ? "" : String.format( ", expected [%s]", expectedCodes.get( name ) ) );
        }*/
write( "==================================================" );
/*        if( !expdNameSet.isEmpty() )
        {
            expdNameSet.stream()
            .forEach( n -> System.out.printf( "No code was generated for [%s], expected [%s].\n",
            n,
            expectedCodes.get( n ) ) );
            System.out.println( "==================================================" );
        }*/
write( "Completed generating Cutter codes" );
