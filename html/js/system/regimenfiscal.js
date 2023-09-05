var app = new Vue({
  el: '#app',
  data: {
    regimenesfiscales: []
    
  },
  mounted: function() {
    this.loadInfo();    
  },
  methods: {
    loadInfo(){
        var vm = this;
                axios.get(URL_BASE + 'api/regimenfiscal.api.php?method=getall', getAxiosHeaders())
                .then(function (response) {
                    
                    console.log(response.data);
                    var list = response.data.list;	
                    list.forEach(o => {
                        o.codigoAux = o.codigo,
                        o.descripcionAux = o.descripcion
                    });
                    vm.regimenesfiscales = response.data.list.filter(o => o.id > 1);	
                    
                })
                .catch(function (error) {
                    console.log(error);
                });
    },
    addNewRegimen: function(){
    
        this.regimenesfiscales.push({id: 0,
            codigo: '', 
            codigoAux: '', 
            descripcion: '', 
            descripcionAux: ''});
    },
    deleteNewRegimen: function (index){
        if (index >= 0){
            this.regimenesfiscales.splice(index, 1);
        }
    },
    saveRegimen: function(index){
        if (index >= 0){
            if (this.regimenesfiscales[index].codigo == ""){
                saInfo("Debe ingresar el código");
                return;
            }

            if (this.regimenesfiscales[index].descripcion == ""){
                saInfo("Debe ingresar el descripción");
                return;
            }

            this.regimenesfiscales[index].codigo = this.regimenesfiscales[index].codigo.toUpperCase();
            this.regimenesfiscales[index].descripcion = this.regimenesfiscales[index].descripcion.toUpperCase();

            var form_data = new FormData();
            form_data.append("idRegimenFiscal", this.regimenesfiscales[index].id);
            form_data.append("codigo", this.regimenesfiscales[index].codigo);
            form_data.append("descripcion", this.regimenesfiscales[index].descripcion);

            var vm = this;
            axios.post(URL_BASE + 'api/regimenfiscal.api.php?method=save', form_data, getAxiosHeaders())
                .then(function (response) {
                    
                    if (!response.data.error)
                    {                        
                        vm.regimenesfiscales[index].id = response.data.idRegimenFiscal;
                        vm.regimenesfiscales[index].codigoAux = vm.regimenesfiscales[index].codigo;
                        vm.regimenesfiscales[index].descripcionAux = vm.regimenesfiscales[index].descripcion;
                        saSuccess("Elemento registrado con éxito");
                    }
                    else
                    {
                        saError(response.data.msg);
                    }
                })
                .catch(function (error) {
                    console.log(error);
                });
        
        }
        else
        {
            saError("Ocurrió un error inexperado");
                
        }
    }
  },
    
});