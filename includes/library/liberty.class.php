<?php
class LibertyReserve
{
	public $debug = false;
	/**
	 * Liberty Reserve API name
	 *
	 * @var string
	 */
	public $api;
	/**
	 * Liberty Reserve API secret word
	 *
	 * @var string
	 */
	public $secretword;
	/**
	 * Generates random ID
	 *
	 * @return <id>
	 */
	public function __construct($api, $secword) {
		$this->api = $api;
		$this->secretword = $secword;
	}
	private function generateId() {
		return time().rand(0,9999);
	}
	/**
	 * Creates authentication token
	 *
	 * @param string $secWord		LR API secret word
	 * @return <authentication token>
	 */
	private function createAuthToken($secWord) {
		$datePart = gmdate("Ymd");
		$timePart = gmdate("H");

		$authString = $secWord.":".$datePart.":".$timePart;

		if (!extension_loaded('mhash')) {
			$hash = strtoupper(hash('sha256', $authString));    
		}
		else {
			$hash = strtoupper(bin2hex(mhash(MHASH_SHA256, $authString)));
		}
		return $hash;
	}
	/**
	 * Gets LR account name
	 *
	 * @param string $Account_number
	 * @return <account name>
	 */
	public function get_account_name($Account_number)
	{
		if (empty($this->api) || empty($this->secretword)) die("LR API doesn't specified.");
		$id=$this->generateId();
		$token=$this->createAuthToken($this->secretword);
		$request="<AccountNameRequest id=\"".$id."\">".
				    "<Auth>".  
				      "<ApiName>".$this->api."</ApiName>".
				      "<Token>".$token."</Token>".
				    "</Auth>".
				    "<AccountName>".  
				      "<AccountId>".$Account_number."</AccountId>".
				      "<AccountToRetrieve>".$Account_number."</AccountToRetrieve>".
				    "</AccountName>".
				  "</AccountNameRequest>";
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,"https://api.libertyreserve.com/xml/accountname.aspx?req=".urlencode($request));
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		if(($response = curl_exec ($ch))==FALSE) die(curl_error($ch));
		curl_close ($ch);
		if ($this->debug) print_r($response);
		$xml = simplexml_load_string($response);

		return $xml->AccountName->Name;
	}

	/**
	 * Gets LR account balance
	 *
	 * @param string $Account_number
	 * @return <balance>
	 */
	public function getBalance($Account_number)
	{
		if (empty($this->api) || empty($this->secretword)) die("LR API doesn't specified.");
		$id=$this->generateId();
		$token=$this->createAuthToken($this->secretword);
		//echo $token;
		$request="<BalanceRequest id=\"".$id."\">".
		  "<Auth>".
		    "<ApiName>".$this->api."</ApiName>".
		    "<Token>".$token."</Token>".
		  "</Auth>".
		  "<Balance>".
		  "<CurrencyId>LRUSD</CurrencyId>".
		  "<AccountId>".$Account_number."</AccountId>".
		  "</Balance>".
		"</BalanceRequest>";
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,"https://api.libertyreserve.com/xml/balance.aspx?req=".urlencode($request));
		//curl_setopt($ch,CURLOPT_URL,"https://www.forum-b2b.ru");
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);
		curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,0);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		if(($response = curl_exec ($ch))==FALSE) die(curl_error($ch));
		curl_close ($ch);
		if ($this->debug) print_r($response);
		$xml = simplexml_load_string($response);

		return $xml->Balance->Value;
	}

	/**
	 * Gets LR account history in XML format
	 *
	 * @param string $xmlfile				XML file path
	 * @param string $Account_number		LR account number
	 * @return <1>
	 */
	public function get_account_history($xmlfile, $Account_number)
	{
		if (empty($this->api) || empty($this->secretword)) die("LR API doesn't specified.");
		$id=$this->generateId();
		$token=$this->createAuthToken($this->secretword);
		$yesterday  = mktime(0, 0, 0, date("m")  , date("d")-1, date("Y"));
		$tomorrow= mktime(0, 0, 0, date("m")  , date("d")+1, date("Y"));
		$startdate=gmdate("Y-d-m H:i:s",$yesterday);
		$enddate=gmdate("Y-d-m H:i:s",$tomorrow);
		$request="<HistoryRequest id=\"".$id."\">".
		  "<Auth>".
		    "<ApiName>".$this->api."</ApiName>".
		    "<Token>".$token."</Token>".
		  "</Auth>".		
		  "<History>".
		    "<AccountId>".$Account_number."</AccountId>".
		    "<From>".$startdate."</From>".
		    "<Till>".$enddate."</Till>".
		  "</History>".
		"</HistoryRequest>";
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,"https://api.libertyreserve.com/xml/history.aspx?req=".urlencode($request));
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		if(($response = curl_exec ($ch))==FALSE) die(curl_error($ch));
		curl_close ($ch);
		if ($this->debug) print_r($response);
		$out = fopen($xmlfile,"w");
		fputs($out, $response);
		fclose($out);

		return 1;
	}

	/**
	 * Finds if AAB exists in XML history file
	 *
	 * @param string $xmlfile				XML file path
	 * @param array  $aab					AcountID, Amount, Batch to find
	 * @return 1 if batch exists, else 0
	 */
	public function aab_from_csv($xmlfile, $aab)
	{
		$xml = simplexml_load_file($xmlfile);
		$batch_exists=0;
		foreach ($xml->Receipt as $item)
		{
			if ($aab[0]==$item->Transfer->Payer && $aab[1]==$item->Transfer->Amount && $aab[2]==$item->ReceiptId)
			{
				$batch_exists=1;
				break;
			}
		}
		return $batch_exists ? 1 : 0;
	}

	/**
	 * Makes LR transfer
	 *
	 * @param string $Payer_account		LR payer account
	 * @param string $Payee_account		LR payee account
	 * @param float  $Amount			LR transfer amount
	 * @param string $Memo				LR transfer memo
	 * @return <batch>
	 */
	public function transfer($Payer_account, $Payee_account, $Amount, $Memo)
	{
		if (empty($this->api) || empty($this->secretword)) die("LR API doesn't specified (transfer).");
		$id=$this->generateId();
		$token=$this->createAuthToken($this->secretword);
		$request="<TransferRequest id=\"".$id."\">".
			  "<Auth>".
			    "<ApiName>".$this->api."</ApiName>".
			    "<Token>".$token."</Token>".
			  "</Auth>".
			  "<Transfer>".
			    "<TransferType>transfer</TransferType>".
			    "<Payer>".$Payer_account."</Payer>".
			    "<Payee>".$Payee_account."</Payee>".
			    "<CurrencyId>LRUSD</CurrencyId>".
			    "<Amount>".$Amount."</Amount>".
			    "<Memo>".$Memo."</Memo>".
			    "<Anonymous>false</Anonymous>".
			  "</Transfer>".
			"</TransferRequest>";	
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,"https://api.libertyreserve.com/xml/transfer.aspx?req=".urlencode($request));
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		if(($response = curl_exec ($ch))==FALSE) die(curl_error($ch));
		curl_close ($ch);
		if ($this->debug) print_r($response);
		$xml = simplexml_load_string($response);
		if (isset($xml->Receipt->ReceiptId)) return $xml->Receipt->ReceiptId; else return 0; 
	}

	/**
	 * Deletes CVS history file
	 *
	 * @param string $csvfile				CVS file path
	 */
	function flush_history($csvfile)
	{
		unlink($csvfile);
	}
	
	private function isValidAccountNumber($acct) 
	{
		return ereg("^(U|X)[0-9]{1,}$", $acct);
	}
}