/************************* BUSCADOR GENERICO ****************************/
/************************* Recordar que los titulos se toman de encabezados ****************************/
/************************* Recordar que solo se puede usar con SPREADSHEETS, no excels ****************************/
/************************* Modificar las variables a continuación salvo values ****************************/
/************************* Es obligatorio que haya una columna de territorio, una de sucursal y una de tipo de cliente ****************************/
var spid='---'; /* Acá va el id del spreadsheet */

/**** ESTAS 3 SON OBLIGATORIAS, EL RESTO SI SE PONEN EN 0 NO APARECEN */
var columnterritorio=8; /* Acá va la columna de territorio del spreadsheet, si es A, va a ser 1, B 2, C 3, etc. */
var columnsucursal=7; /* Acá va la columna de la sucursal del spreadsheet, si es A, va a ser 1, B 2, C 3, etc. */
var columntipocliente=10; /* Acá va la columna del tipo cliente RED o DIRECT (Tiene que decir en esa columna RED o 
DIRECT - RDB entra en direct pero la sucursal es la del cliente y no la del territorio) */
var comofiguranreddirect= ['','']; /* */

/**** ESTAS SON NO OBLIGATORIAS, SE PUEDEN BORRAR, OJO, CON CUIDADO *****/
/**** RECORDAR QUE MATCHEAN ARRAY CON ARRAY (Parecido a como pasa con las hojas en el buscador de acciones comerciales) */
/**** NO BORRAR LAS VARIABLES, O SEA, DEJARLAS CON POR EJEMPLO var columnsbuscables=[] */

/**** Columns buscables: Declarar el numero de columna (O columnas) en la que voy a buscar el dato */
var columnsbuscables=[[3,4], 2, 9];
/**** Nombres column buscables: Declarar el nombre que va a figurar para ese dato que estoy buscando */
var nombrescolumnbuscables=[ 'Nombre/Apellido de Cliente', 'ID de Cliente', 'Ejecutivo']
/**** Tipo dato buscable: ¿El dato solo serviria buscando directs? Lo pongo en 1. Caso contrario, 0. */
var tipodatobuscable=[0,0,1]; /**** 0 PARA RED/RDB, 1 PARA DIRECT, si está en RED también está en DIRECT */
/**** Tipo busqueda: 0 - Coincidencia exacta, 1 - Coincidencia inexacta, 2 mayor que, 3 menor que */
var tipobusqueda=[1,1,1];

/***** VARIABLES NECESARIAS - NO TOCAR */
var values;
var returnAll = new Array();
var gTerri = new Array();
var gSucu = new Array();
var gTC = new Array();
var gTerrySucusyTP = new Array();


function doGet() {
  return HtmlService.createHtmlOutputFromFile('Index');
  
}

function getVals(){
  var ss = SpreadsheetApp.openById(spid);
  SpreadsheetApp.setActiveSpreadsheet(ss);
  var range = ss.getDataRange();
  values = range.getValues();
  
  for (var i=1;i<values.length;i++){
    var duplicate = false;
    for (var x=0;x<gTerri.length;x++){
      if (gTerri[x]==values[i][columnterritorio-1]) duplicate=true; 
    }
    if (!duplicate) gTerri.push(values[i][columnterritorio-1]);    
  }
  
  for (var i=1;i<values.length;i++){
    var duplicate = false;
    for (var x=0;x<gSucu.length;x++){
      if (gSucu[x]==values[i][columnsucursal-1]) duplicate=true; 
    }
    if (!duplicate) gSucu.push(parseInt(values[i][columnsucursal-1]));    
  }
  gSucu.sort((a, b) => a - b);
  
  for (var i=1;i<values.length;i++){
    var duplicate = false;
    for (var x=0;x<gTC.length;x++){
      if (gTC[x]==values[i][columntipocliente-1]) duplicate=true; 
    }
    if (!duplicate) gTC.push(values[i][columntipocliente-1]);    
  }
  gTerrySucusyTP.push(gTerri);
  gTerrySucusyTP.push(gSucu);
  gTerrySucusyTP.push(gTC);

  returnAll.push(values);
  returnAll.push(gTerrySucusyTP);
  returnAll.push(columntipocliente);
  returnAll.push(columnterritorio);
  returnAll.push(columnsucursal);
  returnAll.push(columnsbuscables);
  returnAll.push(nombrescolumnbuscables);
  returnAll.push(tipodatobuscable);
  returnAll.push(comofiguranreddirect);
  returnAll.push(tipobusqueda);
 return JSON.stringify(returnAll);
}

