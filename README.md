#Welcome to Smart Weather Agent repo

###Some guidelines to follow when developing for Spletni Inteligentni Agent (SIA)
###Code standards and guidelines
Do not write more than 100 characters per line

    //A few examples on how to write code
    //All comments and code are in english
    
    //Example for loop
    for (var i = 0; i < value; i++)
    {
        printSomethingOut("Hello world");
    }
    
    //Example function
    function printSomethingOut(variable)
    {
        document.write(variable);
    }
    
    //If sentence
    if (variable < value)
    {
        //Make something
    }
    else
    {
        //Make something else
    }
    
    //Samlple PHP class
    class Father extends Person
    {
        private $son;
        
        public function __construct()
        {
        
        }
        
        public function __construct($son)
        {
            $this->son = $son;
        }
        
        public function setSon($son)
        {
            $this->son = $son;
        }
    }
    
####Documentation and code commenting
Code commenting is mandatory on sections that are not self explanatory.

Once you finish your work you must document it and send it over to Sašo Markovič as he will gather it and manage it further.

####Pull requests and server updates
If you wish to get your code live you can open a pull request or you can ask Jan Haložan to update the code manually.

####Other questions
If you have any other questions you can ask Jan Haložan for help.
