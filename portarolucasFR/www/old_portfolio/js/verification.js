function verifier_allInfo(maForm)
{
	var nomT = verifier_nom(maForm.nomTextBox);
	var mailT = verifier_mail(maForm.emailTextBox);
	var messageT = verifier_message(maForm.messageTextBox);
	if(nomT && mailT && messageT)
	{return true;}
	else
	{
		alert("Veuillez saisir correctement tous les champs du formulaire")
		return false;
	}
}

function verifier_nom(lui)
{
	var value = lui.value;
	if(value.length < 2 || value.length > 50)
	{
		lui.style = "border: 1.5px solid red; border-radius: 5px;";
		return false;
	}
	else
	{
		lui.style = "";
		return true;
	}
}

function verifier_mail(lui)
{
	var regex = /^[a-zA-Z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$/;
	var value = lui.value;
	if(!regex.test(value))
	{
		lui.style = "border: 1.5px solid red; border-radius: 5px;";
		return false;
	}
	else
	{
		if(document.getElementById("errorLabel_Mail"))
		{
			document.getElementById("errorLabel_Mail").style = "display: none;";
		}
		lui.style = "";
		return true;
	}
}

function verifier_message(lui)
{
	var value = lui.value;
	if(value.length < 5 || value.length > 500)
	{
		lui.style = "border: 1.5px solid red; border-radius: 5px;";
		return false;
	}
	else
	{
		lui.style = "";
		return true;
	}
}