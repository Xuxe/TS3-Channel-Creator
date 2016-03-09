<?PHP
class chadd
{
		private function GenString($length = 5)
		{
			return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
		}

		public function ReplaceBadString($words, $string)
		{
			
			$string = str_replace($words, "XXXX", $string);
			return $string;
			
		}
		
		public function CheckStringIP($string)
		{
			return preg_match('/\b(?:[0-9]{1,3}\.){3}[0-9]{1,3}\b/', $string); 
		}
		
		
		public function CheckStringDomain($string)
		{

			$string = str_replace(' ', '', $string); 
			return preg_match('/^ (?: [a-z0-9] (?:[a-z0-9\-]* [a-z0-9])? \. )*    #Subdomains
									[a-z0-9] (?:[a-z0-9\-]* [a-z0-9])?            #Domain
									\. [a-z]{2,6} $                               #Top-level domain
									/ix', $string);
		}
		
		
		public function SetCookie()
		{
			setcookie("_ZB_CHADD", true, time()+604800); /* set a cookie for 7 days */
		}
		
		
		public function CheckCookie()
		{
			if(@$_COOKIE["_ZB_CHADD"] != true)
			{
				return false;
			}
			
			return true;
		}
		
		
}

$chadd = new chadd(); 

?>