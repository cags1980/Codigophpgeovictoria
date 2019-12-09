using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using RestSharp;
using RestSharp.Authenticators;
using Newtonsoft.Json;
using Newtonsoft.Json.Linq;
using Cinchoo;
using ChoETL;

namespace ConsoleApp2
{
    class Program
    {
        // public static object ServiceStack { get; private set; }


        static void Main(string[] args)
        {

            var client = new RestClient("https://apiv3.geovictoria.com/api"); //Url del servicio
            string consumerkey = "1dd229"; //Key publica
            string consumersecret = "43dd1bb2"; //Key privada
            client.Authenticator = OAuth1Authenticator.ForProtectedResource(consumerkey, consumersecret, string.Empty, string.Empty);
            var request = new RestRequest("/AttendanceBook/GetAttendance", Method.POST); //PunchesList/currentWeek. Siempre hágalo mediante POST
                                                                                         //  var request = new RestRequest("/User/List", Method.POST); // /User: Operation. Always use "POST"

            // var request = new RestRequest("/Punch/List/", Method.POST); //PunchesList/currentWeek. Siempre hágalo mediante POST
            request.RequestFormat = DataFormat.Json;
            
            /*
            request.AddJsonBody(new
            {
                Range = "100771896,100898055,101612856,102305531,102659384,104764282,104872123,105967136,107458204,107638504,10915041K,111369496,114710105,114758574,11542890K,115541730,117777073,11881312K,120543792,120997742,122349101,122381676,122542319,122571653,123600274,125056598,12632037K,12635942K,126547110,126706065,12793245K,128314520,128535411,130294456,131067798,132397376,132746559,13462311K,134820098,135479314,137249243,139370732,139391691,140368504,140555576,141364456,14176201K,142428466,143624153,143823466,145351650,145668670,147346794,150466504,151675468,151723012,15326726K,153482225,153522863,153744173,154260021,15443125K,154669671,155837012,156610615,156975133,157034472,157998412,15800433K,158007118,158010143,158223155,159410536,159551679,159680843,160764163,160838914,161139114,161471852,163290367,163545608,164218724,16459520K,165174860,165297199,165466349,165615530,165694953,166374006,166381657,166472814,166952581,166965837,167097367,169209316,169942587,171484472,171510503,172326668,172879888",
                from = "20191203050000",
                to = "20191203235900",
                includeAll = 0
            });*/
            
                       request.AddJsonBody(new { Range = "173020465,173052804,173410476,173422024,173743769,173747136,173763506,173892926,174440336,174974799,175645853,175792996,175797203,176687339,176997079,177397229,177460877,177509698,177671312,177695580,177706949,177707821,178591460,178711229,180723250,180789812,180797459,180889051,180892370,180915435,18150904K,181701366,182483524,183276530,183283251,184429497,184511630,184686929,185698289,186223802,18626357K,186278895,18629565K,188469361,188490840,188510604,188586937,188619169,188802729,189135041,190945219,191645197,191875079,192334640,192846420,193112889,193127398,193432999,19370803K,193788963,194199570,194411537,195278067,195444676,195479410,195482586,19882383K,198837261,198858900,200496795,200528050,224992904,231880267,236671305,237357329,244390226,252023372,254529931,257124398,258188993,259022428,259866332,261664240,262744876,265775705,265819125,267964335,46738268,61871942,63809810,67025695,68880122,70390779,76298858,76869987,76878749,81685193,8302173K,87170241,87752682,89630096,9297250K,94746191,96125577,97686394", 
                from = "20191203050000", to = "20191203235900",  
            includeAll=0 });
            // request.AddJsonBody(new { Range = "customRange", from = "20190801060000", to = "20190802235900" });
            var response = client.Execute(request);
            var content = response.Content; //Obtener la respuesta
                                            // var records =Object;
            Console.WriteLine(content); //Ver respuesta en pantalla
            System.IO.File.WriteAllText(@"salidaVictoria.json", content);
            // Console.WriteLine("Press any key to continue...");
            // Console.ReadKey();
            System.IO.File.WriteAllText(@"c:\temp\salidaVictoria.json", content);
            //var records = ServiceStack.Text.CsvSerializer.SerializeToCsv(content);
            //System.IO.File.WriteAllText(@"c:\temp\salidaVictoria.cvs", records);
            //jsonStringToCSV(content);
            dynamic array = JsonConvert.DeserializeObject(content);

            List<string> lineas = ((JArray)array).Select(node => string.Join(",", ((JObject)node).Properties().Select(p => p.Value))).ToList();
            System.IO.File.WriteAllLines(@"C:\temp\resultado1_3.csv", lineas);




            Console.ReadKey();

        }




    }
}
