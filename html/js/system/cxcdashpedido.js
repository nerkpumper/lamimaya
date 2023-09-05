var app = new Vue({
  el: "#app",
  data: {
    idCliente: 0,

    idPedido: "",
    idPedidoFilter: '',
    seleccionandoCliente: true,

    //datos cliente
    nombre: "",
    empresa: "",
    domicilio1: "",
    domicilio2: "",
    numero: "",
    colonia: "",
    ciudad: "",
    telefonos: "",
    email: "",
    rfc: "",
    estado: "",
    promotor: "",
    cteCredito: 0,
    cteCapacidadPago: 0,
    disponibleRD: 0,
    creditousado: 0,

    pedidoscapturado: 0,
    pedidosautorizado: 0,
    pedidosproduccion: 0,
    pedidosterminado: 0,
    pedidostotal: 0,

    filtroNombreCliente: "",

    clientes: [],
    tracking: [],
  },
  mounted: function () {
    // alert("hola usuario " + _IDUSUARIO );

    this.cargarClientes();

    if (typeof param1 !== "undefined") {
      this.idCliente = param1;
      this.seleccionandoCliente = false;
      setTimeout(function () {
        app.seleccionarCliente(app.idCliente);
      }, 500);
    }

    // this.tracking.push({
    //   idPedido: 10,
    //   msg: "este es un msg",
    //   fecha: "2020-07-02 10:10:00",
    //   tipo: "INFO",
    // });

    // this.tracking.push({
    //   idPedido: 10,
    //   msg: "este es un msg",
    //   fecha: "2020-07-02 10:10:00",
    //   tipo: "WARNING",
    // });

    // this.tracking.push({
    //   idPedido: 10,
    //   msg: "este es un msg",
    //   fecha: "2020-07-02 10:10:00",
    //   tipo: "SUCCESS",
    // });

    // this.tracking.push({
    //   idPedido: 10,
    //   msg: "este es un msg",
    //   fecha: "2020-07-02 10:10:00",
    //   tipo: "ERROR",
    // });
  },
  computed: {
    barcredito: function () {
      if (this.cteCredito <= 0) return 0;

      var por = (this.creditousado * 100) / this.cteCredito;

      return por > 100 ? 100 : por;
    },
    barcapacidadpago: function () {
      if (this.cteCapacidadPago <= 0) return 0;

      var por = (this.creditousado * 100) / this.cteCapacidadPago;

      return por > 100 ? 100 : por;
    },
    csscredito: function () {
      return this.barcredito <= 50
        ? ""
        : this.barcredito > 50.0 && this.barcredito <= 75.0
        ? "progress-bar-warning"
        : "progress-bar-danger";
    },
    csscapacidadpago: function () {
      return this.barcapacidadpago <= 50
        ? ""
        : this.barcapacidadpago > 50.0 && this.barcapacidadpago <= 75.0
        ? "progress-bar-warning"
        : "progress-bar-danger";
    },
    clientesFiltradosPorNombre: function () {
      var self = this;
      return this.clientes.filter(function (cust) {
        var str = cust.nombre;
        var find = self.filtroNombreCliente;

        return str.includes(find);
      });
    },
    trackingFiltrado: function () {
      var self = this;
      return this.tracking.filter(function (cust) {
        // var str = cust.idPedido;
        var find = self.idPedidoFilter;

        return cust.idPedido == self.idPedidoFilter || self.idPedidoFilter == '';
      });
    },
  },
  methods: {
    cargarClienteDePedido: function () {
      if (this.idPedido == "") {
        saTexto("Indique el Número de Pedido");
        return;
      }

      if (this.idPedido == 0) {
        saTexto("Indique el Número de Pedido");
        return;
      }

      xajax_cargarClienteDePedido(this.idPedido);
    },
    cargarClientes: function () {
      xajax_cargarClientes();
    },
    seleccionarCliente: function (idCliente) {
      this.seleccionandoCliente = false;
      this.idCliente = idCliente;

      mdlShowWait();
      xajax_cargarCliente(this.idCliente);
    },
    seleccionarOtroCliente: function () {
      this.seleccionandoCliente = true;
    },
    dejarCliente: function () {
      this.seleccionandoCliente = false;
    },
    cargarPedidos: function () {
      xajax_cargarPedidos(this.idCliente);
    },
    cargarTracking: function (){
      xajax_cargarTracking(this.idCliente);
    },
    getClassByTipo: function (tipo) {
      var css = "blue-bg";

      if (tipo == "SUCCESS") 
      {
        css = "navy-bg";
      } 
      else if(tipo == "ERROR")
      {
        css = "red-bg";
      }
      else if (tipo == "WARNING")
      {
        css = "yellow-bg";
      }
      
      
      
      return css;
    },
    getIconByTipo: function (tipo) {
      var css = "fa fa-quote-right";

      if (tipo == "SUCCESS") 
      {
        css = "fa fa-check";
      } 
      else if(tipo == "ERROR")
      {
        css = "fa fa-times";
      }
      else if (tipo == "WARNING")
      {
        css = "fa fa-warning";
      }
      
      
      
      return css;
    },
  },
});

$(document).ready(function () {
  $("#collapseLeftMenu").click();
});
