<?php


/*
 * 
5 . TODO Realocar estas funções
 */
function formatarValor( $valor) {
    return str_replace( '.', ',', number_format( $valor, 2));
}

function validEmail($email)
{
   $isValid = true;
   $atIndex = strrpos($email, "@");
   if (is_bool($atIndex) && !$atIndex)
   {
      $isValid = false;
   }
   else
   {
      $domain = substr($email, $atIndex+1);
      $local = substr($email, 0, $atIndex);
      $localLen = strlen($local);
      $domainLen = strlen($domain);
      if ($localLen < 1 || $localLen > 64)
      {
         // local part length exceeded
         $isValid = false;
      }
      else if ($domainLen < 1 || $domainLen > 255)
      {
         // domain part length exceeded
         $isValid = false;
      }
      else if ($local[0] == '.' || $local[$localLen-1] == '.')
      {
         // local part starts or ends with '.'
         $isValid = false;
      }
      else if (preg_match('/\\.\\./', $local))
      {
         // local part has two consecutive dots
         $isValid = false;
      }
      else if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain))
      {
         // character not valid in domain part
         $isValid = false;
      }
      else if (preg_match('/\\.\\./', $domain))
      {
         // domain part has two consecutive dots
         $isValid = false;
      }
      else if
(!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/',
                 str_replace("\\\\","",$local)))
      {
         // character not valid in local part unless
         // local part is quoted
         if (!preg_match('/^"(\\\\"|[^"])+"$/',
             str_replace("\\\\","",$local)))
         {
            $isValid = false;
         }
      }
      if ($isValid && !(checkdnsrr($domain,"MX") || checkdnsrr($domain,"A")))
      {
         // domain not found in DNS
         $isValid = false;
      }
   }
   return $isValid;
}

function formatarDinheiro($numero)
{
	if(strpos($numero,'.')!='')
	{
		   $var=explode('.',$numero);
		   if(strlen($var[0])==4)
		   {
		     $parte1=substr($var[0],0,1);
		     $parte2=substr($var[0],1,3);
		     if(strlen($var[1])<2)
		     {
		     	$formatado=$parte1.'.'.$parte2.','.$var[1].'0';
		     }else
		     {
		     	$formatado=$parte1.'.'.$parte2.','.$var[1];
		     }
		   }
		   elseif(strlen($var[0])==5)
		   {
		     $parte1=substr($var[0],0,2);
		     $parte2=substr($var[0],2,3);
		     if(strlen($var[1])<2)
		     {
		     	$formatado=$parte1.'.'.$parte2.','.$var[1].'0';
		     }
		     else
		     {
		     	$formatado=$parte1.'.'.$parte2.','.$var[1];
		     }
		   }
		   elseif(strlen($var[0])==6)
		   {
		     $parte1=substr($var[0],0,3);
		     $parte2=substr($var[0],3,3);
		     if(strlen($var[1])<2)
		     {
		     	$formatado=$parte1.'.'.$parte2.','.$var[1].'0';
		     }
		     else
		     {
		     	$formatado=$parte1.'.'.$parte2.','.$var[1];
		     }
		   }
		   elseif(strlen($var[0])==7)
		   {
		     $parte1=substr($var[0],0,1);
		     $parte2=substr($var[0],1,3);
		     $parte3=substr($var[0],4,3);
		     if(strlen($var[1])<2)
		     {
		     	$formatado=$parte1.'.'.$parte2.'.'.$parte3.','.$var[1].'0';
		     }
		     else
		     {
		     $formatado=$parte1.'.'.$parte2.'.'.$parte3.','.$var[1];
		     }
		   }
		   elseif(strlen($var[0])==8)
		   {
		     $parte1=substr($var[0],0,2);
		     $parte2=substr($var[0],2,3);
		     $parte3=substr($var[0],5,3);
		     if(strlen($var[1])<2){
		     $formatado=$parte1.'.'.$parte2.'.'.$parte3.','.$var[1].'0';
		     }else{
		     $formatado=$parte1.'.'.$parte2.'.'.$parte3.','.$var[1];
		     }
		   }
		   elseif(strlen($var[0])==9)
		   {
		     $parte1=substr($var[0],0,3);
		     $parte2=substr($var[0],3,3);
		     $parte3=substr($var[0],6,3);
		     if(strlen($var[1])<2)
		     {
		     	$formatado=$parte1.'.'.$parte2.'.'.$parte3.','.$var[1].'0';
		     }
		     else
		     {
		     	$formatado=$parte1.'.'.$parte2.'.'.$parte3.','.$var[1];
		     }
		   }
		   elseif(strlen($var[0])==10)
		   {
		     $parte1=substr($var[0],0,1);
		     $parte2=substr($var[0],1,3);
		     $parte3=substr($var[0],4,3);
		     $parte4=substr($var[0],7,3);
		     if(strlen($var[1])<2)
		     {
		     	$formatado=$parte1.'.'.$parte2.'.'.$parte3.'.'.$parte4.','.$var[1].'0';
		     }
		     else
		     {
		     	$formatado=$parte1.'.'.$parte2.'.'.$parte3.'.'.$parte4.','.$var[1];
		     }
		   }
		   else
		   {
		     if(strlen($var[1])<2)
		     {
		    	 $formatado=$var[0].','.$var[1].'0';
		     }
		     else
		     {
		    	 $formatado=$var[0].','.$var[1];
		     }
		   }
	  }
	  else
	  {
	     $var=$numero;
	   if(strlen($var)==4)
	   {
	     $parte1=substr($var,0,1);
	     $parte2=substr($var,1,3);
	     $formatado=$parte1.'.'.$parte2.','.'00';
	   }
	   elseif(strlen($var)==5)
	   {
	     $parte1=substr($var,0,2);
	     $parte2=substr($var,2,3);
	     $formatado=$parte1.'.'.$parte2.','.'00';
	   }
	   elseif(strlen($var)==6)
	   {
	     $parte1=substr($var,0,3);
	     $parte2=substr($var,3,3);
	     $formatado=$parte1.'.'.$parte2.','.'00';
	   }
	   elseif(strlen($var)==7)
	   {
	     $parte1=substr($var,0,1);
	     $parte2=substr($var,1,3);
	     $parte3=substr($var,4,3);
	     $formatado=$parte1.'.'.$parte2.'.'.$parte3.','.'00';
	   }
	   elseif(strlen($var)==8)
	   {
	     $parte1=substr($var,0,2);
	     $parte2=substr($var,2,3);
	     $parte3=substr($var,5,3);
	     $formatado=$parte1.'.'.$parte2.'.'.$parte3.','.'00';
	   }
	   elseif(strlen($var)==9)
	   {
	     $parte1=substr($var,0,3);
	     $parte2=substr($var,3,3);
	     $parte3=substr($var,6,3);
	     $formatado=$parte1.'.'.$parte2.'.'.$parte3.','.'00';
	   }
	   elseif(strlen($var)==10)
	   {
	     $parte1=substr($var,0,1);
	     $parte2=substr($var,1,3);
	     $parte3=substr($var,4,3);
	     $parte4=substr($var,7,3);
	     $formatado=$parte1.'.'.$parte2.'.'.$parte3.'.'.$parte4.','.'00';
	   }
	   else
	   {
	     $formatado=$var.','.'00';
	   }
	}
	  return $formatado;
}

?>
