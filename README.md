#Welcome to Smart Weather Agent repo

##HOWTOSETUP DEVELOPMENT STUFF
Na hitro v srjanscini, ker sem popizdovo poleg.

1. nasnemli php 5+, enable curl pa mcrypt. Najlaze z WAMP (ma ze vse vklopleno), ali pa XAMP in alternative

2. naredi mysql server z bazo

3. kreiraj bazo 'development' z uporanbikom 'developer' in geslom 'Sup3rG3sL0', pa mu dej dostop nad vsem (tam daj tudi da mu dovolo local dostop)

4. cloniraj projekt nekam na komp

5. premakni se v laravel mapo in zazeni: (php more biti pot do tvojega php executabla, za win userje je to v xamp folderi nekje)

php artisan migrate

php artisan db:seed

6. sedaj treba pognati fetcherja, ker drugaci stran sploh ne dela, idi v mapo fetcher

php fetcher.php

php forecast_fetcher.php (to mogoce ni potrebno)

7. preveri ce je b bazi kaj shranjeno v weather_current. obvezno ke je za ID 2 (ljubljana), ker je stran trenutno hardcodana na to

8. v /laravel/app/config/app.php nastavi debug => true, ker drugaci ce gre kej narobe bos samo buljo v ekran

8. pozeni z php artisan serve

9. idi na stran, upej bokmater ke ti dela, in bi moglo pokazati vsaj index page z nekimi current podatki


###Some guidelines to follow when developing for Spletni Inteligentni Agent (SIA)
###Code standards and guidelines
Do not write more than 100 characters per line

    //A few examples on how to write code
    //All comments and code are in english
    
    //Example of a for loop
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
    
    //Example of an arithmetic expression
    var something = 2 * (3 + pow(3, 2) * log(functionThatReturns4()));
    
####Documentation and code commenting
Code commenting is mandatory on sections that are not self explanatory.

Once you finish your work you must document it and send it over to Sašo Markovič as he will gather it and manage it further.

####Pull requests and server updates
If you wish to get your code live you can open a pull request or you can ask Jan Haložan to update the code manually.

####Other questions
If you have any other questions you can ask Jan Haložan for help.
