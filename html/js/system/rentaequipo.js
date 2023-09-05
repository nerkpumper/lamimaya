var app = new Vue({
    el: '#app',
    data: {
      msgError: '',
      blnCampoAChecarEsValido: true,
      otroOperador: true,
      otroAyudante: true, 
      folio: 0,
      fecha_captura:    '',
      nombreOperario1:  '',
      sueldoHr1:  0,
      nombreOperario2:  '',
      sueldoHr2:  0,
      ayudante: '',
      sueldoAyudante:  0,
      tipoCombustible:  0,
      costoLitro: 0,
      litrosConsumidos :  0,
      totalRentaEquipo: 0,
      totalOperario: 0,
      totalCombustible: 0,
      horasTrabajadas: 0,
      msgError:'',
      mensaje: 'Hola Chava',
      
      total: 0,

      errfolio:'',
      errfecha_captura:''
    },


    watch: {
      nombreOperario1: function (val) { 
          if (this.nombreOperario1 == "Alejandro Olaes Fraga"){ this.sueldoHr1 = 104.16;}
          if (this.nombreOperario1 == "Pedro Antonio Ponce Contreras"){this.sueldoHr1 = 62.5;}
          },   
          
          folio: function(val){
			
            this.errfolio = "";
            
            if (this.folio == '' || this.folio < 1)
            {
              this.errfolio = "Introduzca valor";
              return;
            }
          },
          fecha_captura: function(val){
			
            this.errfecha_captura = "";
            
            if (this.fecha_captura == '' || this.fecha_captura == '0000-00-00')
            {
              this.errfecha_captura = "Introduzca fecha valida";
              return;
            }
          }
        },
    methods:{
      limpiarCampos: function(){ 
       
         this.folio = 0, 
         this.fecha_captura ='',
         this.totalRentaEquipo = 0,
         this.nombreOperario1 = '',
         this.sueldoHr1 = 0,
         this.nombreOperario2 = '',
         this.sueldoHr2 = 0,  
         this.ayudante= '',
         this.sueldoAyudante= 0,
         this.horasTrabajadas= 0,
         this.tipoCombustible = '',
         this.costoLitro = 0, 
         this.litrosConsumidos = 0,
         this.totalOperario =0,   
         this.totalCombustible = 0, 
         this.total= 0 
         },    
    



      guardarRentaEquipo: function(){ 

        xajax_guardarRentaEquipo(
         this.folio, 
         this.fecha_captura,
         this.totalRentaEquipo,
         this.nombreOperario1,
         this.sueldoHr1,
         this.nombreOperario2,
         this.sueldoHr2,  
         this.ayudante,
         this.sueldoAyudante,
         this.horasTrabajadas, 
         this.tipoCombustible,
         this.costoLitro, 
         this.litrosConsumidos,
         this.totalOperario,  
         this.totalCombustible, 
         this.total);   
         }    
    },
  });