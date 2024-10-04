<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Word Frequency Counter</title>
    <link rel="stylesheet" type="text/css" href="styles.css">

</head>
<body>
    <h1>Word Frequency Counter</h1>
    
    <form action="index.php" method="post">
        <label for="text">Paste your text here:</label><br>
        <textarea id="text" name="text" rows="10" cols="50" placeholder="Sample txt here!..." required></textarea><br><br>
        <div class="choices">
            <div>
                <label for="sort">Sort by frequency:</label>
                <select id="sort" name="sort">
                    <option value="asc">Ascending</option>
                    <option value="desc">Descending</option>
                </select><br><br>
            </div>
            <div>
                <label for="limit">Number of Words:</label>
                <input type="number" id="limit" name="limit" value="10" min="1"><br><br>
            </div>
        </div>
        <input type="submit" value="Calculate Word Frequency">
    </form>
    <div class="result_display">
        <h2>Unique Word Frequencies</h2>
        <table>
            <tr>
                <th>Unique Words</th>
                <th>Frequency</th>
            </tr>

        <?php

            $text_input = @$_POST["text"];
            $asc_desc = @$_POST["sort"];
            $words_limit = @$_POST["limit"];
            $wordCounter=0;
            $freqCounter=0;

            function tokenizeTextInput(string $textInput) : array {

                $tokens =[];
                
                //replace all exclamation, commas etc. into spaces (" ") 
                $cleanedInput = str_replace(["\r\n", "\r", "\n","!",",","?",".","(",")","-"], " ", $textInput);
                $tokens = explode(" ", trim($cleanedInput)); //remove all spaces
                $tokens = array_filter($tokens);             //remove empty elements
                return $tokens;

                }

            function frequencyCalc(string $textInput) : array {
                $stopWords = ['a','the','and','or','of','on','this',
                'we','were','is','not'];            //Just common Words
                $tokenFrequency = [];
                $tokens = tokenizeTextInput($textInput);
                
                foreach ($tokens as $key) {           
                    if (in_array($key, $stopWords)){    //check if word is in stopwords
                        continue;
                    } 
                    if (isset($tokenFrequency[$key])) { //if word is in tokenfrequency array,
                        $tokenFrequency[$key]++;        // if it is, increment,
                    } else {
                        $tokenFrequency[$key]= 1;       //if not append it and put a value of 1
                    }
                }

                return $tokenFrequency;
                }
            
            function ascOrDesc(array $tokenNized, $asc_desc) : array {
                
                if ($asc_desc == "asc") {       //if asec it is ascending(asort())
                    asort($tokenNized);
                    return $tokenNized;
                } else {                        //else desc it is descending(arsort())
                    arsort($tokenNized);
                    return $tokenNized;
                }
                
            }
                
            if ($text_input == null) {
                echo "Enter Text First" ;
            } else {

                $txt = frequencyCalc($text_input);  //calls frequency calculation function
                $txt = ascOrDesc($txt,$asc_desc);   //calls ascending or desending function
                $var = 0;
               
                foreach ($txt as $key => $value) {
                    
                    if ($var < $words_limit) {
                        echo "<tr>";
                        echo "<td>$key</td>";
                        $wordCounter++;
                        echo "<td>$value</td>";
                        $freqCounter = $freqCounter+$value;
                        echo "</tr>";

                        $var++;
                    }else {
                        break;
                    }
                }
                echo "<tr>";
                echo "<td><b>Total: $wordCounter</b></td>";
                echo "<td><b>Total: $freqCounter</b></td>";
                echo "</tr>";

            }
            
            

        ?>
        </table>

    </div>

</body>
</html>


