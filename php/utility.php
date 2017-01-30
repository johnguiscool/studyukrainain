<?php 

function generate_login_message($login_message_function_input_username)
{
	
	if(isset($login_message_function_input_username))
	{
	
		return "Logged in as: ".$login_message_function_input_username."<br> <a href= \"/logout.php\">Log out</a>";
	
	}
	else
	{
		return "<a href=\"/login.php\"> Log in</a> or <a href=\"/register.php\">register</a>";
	}

}

function check_against_whitelist($whitelist_input_string)
{
	
	$whitelist_input_string_length = strlen($whitelist_input_string);  //get white list input string length
	
	$flag = TRUE;
	
	 for ($n = 0; $n < $whitelist_input_string_length; $n++)
	
	{
		if(!character_in_whitelist($whitelist_input_string[0]))
		{
			$flag = FALSE;
		}
		
		$whitelist_input_string = cutoff_first_character($whitelist_input_string);		
	}
	
		
	return $flag;
	

}

function cutoff_first_character($cutoff_input)
{
	 return substr($cutoff_input, 1);
}

function character_in_whitelist($in_whitelist_input)
{
	//Hardcoded definition of the whitelist, only alphanumeric characters
	$whitelist = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
	
	$whitelist_length = strlen($whitelist);
	
	$flag2 = FALSE;
	
	for ($n = 0; $n < $whitelist_length; $n++)
	{
		if($whitelist[$n] == $in_whitelist_input)
			{
			
			//if the character $in_whitelist_input ever matches something from the whitelist, the flag is turned on
			$flag2 = TRUE;
			}
			
		else
			{
			
			//nothing
			}
	
	}
	
	
	return $flag2;
}

class TranslitUk
{
    public $alphabet = array (
        // upper case
        'А' => 'A',     'Б' => 'B',     'В' => 'V',     'Г' => 'H',
        'ЗГ' => 'Zgh',  'Зг' => 'Zgh',  'Ґ' => 'G',     'Д' => 'D',
        'Е' => 'E',     'Є' => 'Ye',    'Ж' => 'Zh',    'З' => 'Z',
        'И' => 'Y',     'І' => 'I',     'Ї' => 'Yi',     'Й' => 'Y',
        'К' => 'K',     'Л' => 'L',     'М' => 'M',     'Н' => 'N',
        'О' => 'O',     'П' => 'P',     'Р' => 'R',     'С' => 'S',
        'Т' => 'T',     'У' => 'U',     'Ф' => 'F',     'Х' => 'X',
        'Ц' => 'Ts',    'Ч' => 'Ch',    'Ш' => 'Sh',    'Щ' => 'Shch',
        'Ь' => '',      'Ю' => 'Yu',    'Я' => 'Ya',    '’' => '',
        // lower case
        'а' => 'a',     'б' => 'b',     'в' => 'v',     'г' => 'h',
        'зг' => 'zgh',  'ґ' => 'g',     'д' => 'd',     'е' => 'e',
        'є' => 'ye',    'ж' => 'zh',    'з' => 'z',     'и' => 'y',
        'і' => 'i',     'ї' => 'yi',     'й' => 'y',     'к' => 'k',
        'л' => 'l',     'м' => 'm',     'н' => 'n',     'о' => 'o',
        'п' => 'p',     'р' => 'r',     'с' => 's',     'т' => 't',
        'у' => 'u',     'ф' => 'f',     'х' => 'x',    'ц' => 'ts',
        'ч' => 'ch',    'ш' => 'sh',    'щ' => 'shch',  'ь' => '',
        'ю' => 'yu',    'я' => 'ya',    '\'' => '',
    );
    public function convert($text)
    {
        return str_replace(
            array_keys($this->alphabet),
            array_values($this->alphabet),
            preg_replace(
                // use alternative variant at the beginning of a word
                array (
                    '/(?<=^|\s)Є/', '/(?<=^|\s)Ї/', '/(?<=^|\s)Й/',
                    '/(?<=^|\s)Ю/', '/(?<=^|\s)Я/', '/(?<=^|\s)є/',
                    '/(?<=^|\s)ї/', '/(?<=^|\s)й/', '/(?<=^|\s)ю/',
                    '/(?<=^|\s)я/',
                ),
                array (
                    'Ye', 'Yi', 'Y', 'Yu', 'Ya', 'ye', 'yi', 'y', 'yu', 'ya',
                ),
                $text)
        );
    }
}



?>