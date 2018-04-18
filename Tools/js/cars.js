function car_type()
{
	var type_site_select = document.getElementById("site_type_selector");
	var site_type = type_site_select.options[type_site_select.selectedIndex].value;
	switch(site_type)
	{
		case ("Guardians_Ruins"):
			set_enable();
			clean_option_from_select("car_select");
			add_option_to_select("Tous", 0);
			add_option_to_select("Alpha", 1);
			add_option_to_select("Beta", 2);
			add_option_to_select("Gamma", 3);
			add_option_to_select("Epsilon", 4);
		break;
		case ("Guardians_Structures"):
			set_enable();
			clean_option_from_select("car_select");
			add_option_to_select("Tous", 0);
			add_option_to_select("Active", 1);
			add_option_to_select("Innactive", 2);
		break;
		case ("Thargoid_Site"):
			set_enable();
			clean_option_from_select("car_select");
			add_option_to_select("Tous", 0);
			add_option_to_select("Active", 1);
			add_option_to_select("Innactive", 2);
		break;
		case ("Nebula"):
			clean_option_from_select();
			set_disabled();
		break;
		case ("INRA"):
			clean_option_from_select();
			set_disabled();
		break;
		default:
			clean_option_from_select();
			set_disabled();
	}
}

function clean_option_from_select()
{
	var myNode = document.getElementById("car_select");
	while (myNode.firstChild) 
	{
    	myNode.removeChild(myNode.firstChild);
	}
}

function set_enable()
{
	var myNode = document.getElementById("car_select");
	myNode.removeAttribute("disabled");
}
function set_disabled()
{
	var myNode = document.getElementById("car_select");
	var d = myNode.setAttribute("disabled", "disabled");
}

function add_option_to_select(option_value, id)
{

	var newChild = document.createElement("option");

	newChild.setAttribute("id", "option");	
var t =document.createTextNode(option_value);
	newChild.appendChild(t);

	document.getElementById("car_select").appendChild(newChild);
}