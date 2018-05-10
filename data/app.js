var app = angular.module('scotchApp', ['ngRoute','ngResource','ngStorage']);

app.directive('hcChart', function () {
    return {
        restrict: 'E',
        template: '<div></div>',
        scope: {
            options: '='
        },
        link: function (scope, element) {
            Highcharts.chart(element[0], scope.options);
        }
    };
})

app.directive('hcPieChart', function() {
    return {
        restrict: 'E',
        template: '<div></div>',
        scope: {
            title: '@',
            data: '='
        },
        link: function (scope, element) {
            Highcharts.chart(element[0], {
                chart: {
                    type: 'pie'
                },
                title: {
                    text: scope.title
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                        }
                    }
                },
                series: [{
                    data: scope.data
                }]
            });
        }
    };
})

// configure our routes
app.config(function($routeProvider) {
    $routeProvider
        // route page initial
        .when('/', {
            templateUrl : 'data/inicio/index.html',
            // controller  : 'mainController',
            activetab: 'inicio'
        })
        // route empresa
        .when('/empresa', {
            templateUrl : 'data/empresa/index.html',
            controller  : 'empresaController',
            activetab: 'empresa'
        })
        // route ambiente
        .when('/tipo_ambiente', {
            templateUrl : 'data/tipo_ambiente/index.html',
            controller  : 'tipo_ambienteController',
            activetab: 'tipo_ambiente'
        })
        // route emision
        .when('/tipo_emision', {
            templateUrl : 'data/tipo_emision/index.html',
            controller  : 'tipo_emisionController',
            activetab: 'tipo_emision'
        })
        // route tipo comprobante
        .when('/tipo_comprobante', {
            templateUrl : 'data/tipo_comprobante/index.html',
            controller  : 'tipo_comprobanteController',
            activetab: 'tipo_comprobante'
        })
        // route tipo documento
        .when('/tipo_documento', {
            templateUrl : 'data/tipo_documento/index.html',
            controller  : 'tipo_documentoController',
            activetab: 'tipo_documento'
        })
        // route tipo producto
        .when('/tipo_producto', {
            templateUrl : 'data/tipo_producto/index.html',
            controller  : 'tipo_productoController',
            activetab: 'tipo_producto'
        })
        // route tipo impuesto
        .when('/tipo_impuesto', {
            templateUrl : 'data/tipo_impuesto/index.html',
            controller  : 'tipo_impuestoController',
            activetab: 'tipo_impuesto'
        })
        // route tarifa impuesto
        .when('/tarifa_impuesto', {
            templateUrl : 'data/tarifa_impuesto/index.html',
            controller  : 'tarifa_impuestoController',
            activetab: 'tarifa_impuesto'
        })
        // route formas pago
        .when('/formas_pago', {
            templateUrl : 'data/formas_pago/index.html',
            controller  : 'formas_pagoController',
            activetab: 'formas_pago'
        })
        // route facturero
        .when('/facturero', {
            templateUrl : 'data/facturero/index.html',
            controller  : 'factureroController',
            activetab: 'facturero'
        })
        // route categorias
        .when('/categorias', {
            templateUrl : 'data/categorias/index.html',
            controller  : 'categoriasController',
            activetab: 'categorias'
        })
        // route marcas
        .when('/marcas', {
            templateUrl : 'data/marcas/index.html',
            controller  : 'marcasController',
            activetab: 'marcas'
        })
        // route unidades de medida
        .when('/medida', {
            templateUrl : 'data/medida/index.html',
            controller  : 'medidaController',
            activetab: 'medida'
        })
        // route bodegas
        .when('/bodegas', {
            templateUrl : 'data/bodegas/index.html',
            controller  : 'bodegasController',
            activetab: 'bodegas'
        })
        // route clientes
        .when('/clientes', {
            templateUrl : 'data/clientes/index.html',
            controller  : 'clientesController',
            activetab: 'clientes'
        })
        // route proveedores
        .when('/proveedores', {
            templateUrl : 'data/proveedores/index.html',
            controller  : 'proveedoresController',
            activetab: 'proveedores'
        })
        // route productos
        .when('/productos', {
            templateUrl : 'data/productos/index.html',
            controller  : 'productosController',
            activetab: 'productos'
        })
        // route importar
        .when('/importar', {
            templateUrl : 'data/importar/index.html',
            controller  : 'importarController',
            activetab: 'importar'
        })
         // route inventario
        .when('/inventario', {
            templateUrl : 'data/inventario/index.html',
            controller  : 'inventarioController',
            activetab: 'inventario'
        })
        // route movimientos
        .when('/movimientos', {
            templateUrl : 'data/movimientos/index.html',
            controller  : 'movimientosController',
            activetab: 'movimientos'
        })
          // route login
        .when('/login', {
            templateUrl : 'data/login/index.html',
            controller  : 'loginController',
        })
        // proceso proformas
        .when('/proformas', {
            templateUrl : 'data/proformas/index.html',
            controller  : 'proformasController',
            activetab: 'proformas'
        })
        // proceso factura compra
        .when('/factura_compra', {
            templateUrl : 'data/factura_compra/index.html',
            controller  : 'factura_compraController',
            activetab: 'factura_compra'
        })
        // proceso factura venta
        .when('/factura_venta', {
            templateUrl : 'data/factura_venta/index.html',
            controller  : 'factura_ventaController',
            activetab: 'factura_venta'
        })
        // proceso factura venta
        .when('/validar_facturas', {
            templateUrl : 'data/validar_facturas/index.html',
            controller  : 'validar_facturasController',
            activetab: 'validar_facturas'
        })
        // proceso nota credito
        .when('/nota_credito', {
            templateUrl : 'data/nota_credito/index.html',
            controller  : 'nota_creditoController',
            activetab: 'nota_credito'
        })
        // proceso ingresos
        .when('/ingresos', {
            templateUrl : 'data/ingresos/index.html',
            controller  : 'ingresosController',
            activetab: 'ingresos'
        })
        // proceso egresos
        .when('/egresos', {
            templateUrl : 'data/egresos/index.html',
            controller  : 'egresosController',
            activetab: 'egresos'
        })
        // route kardex
        .when('/kardex', {
            templateUrl : 'data/kardex/index.html',
            controller  : 'kardexController',
            activetab: 'kardex'
        })
        // route cargos
        .when('/cargos', {
            templateUrl : 'data/cargos/index.html',
            controller  : 'cargosController',
            activetab: 'cargos'
        })
        // route usuarios
        .when('/usuarios', {
            templateUrl : 'data/usuarios/index.html',
            controller  : 'usuariosController',
            activetab: 'usuarios'
        })
        // route privilegios
        .when('/privilegios', {
            templateUrl : 'data/privilegios/index.html',
            controller  : 'privilegiosController',
            activetab: 'privilegios'
        })
        // route cuenta
        .when('/cuenta', {
            templateUrl : 'data/cuenta/index.html',
            controller  : 'cuentaController',
            activetab: 'cuenta'
        })
        // proceso reportes productos
        .when('/reporte_productos', {
            templateUrl : 'data/reporte_productos/index.html',
            controller  : 'reporte_productosController',
            activetab: 'reporte_productos'
        })
        // proceso reportes compras
        .when('/reporte_compras', {
            templateUrl : 'data/reporte_compras/index.html',
            controller  : 'reporte_comprasController',
            activetab: 'reporte_compras'
        })
        // proceso reportes ventas
        .when('/reporte_ventas', {
            templateUrl : 'data/reporte_ventas/index.html',
            controller  : 'reporte_ventasController',
            activetab: 'reporte_ventas'
        })
});

app.factory('Auth', function($location) {
    var user;
    return {
        setUser : function(aUser) {
            user = aUser;
        },
        isLoggedIn : function() {
            var ruta = $location.path();
            var ruta = ruta.replace("/","");
            var accesos = JSON.parse(Lockr.get('users'));
                accesos.push('inicio');
                accesos.push('');

            var a = accesos.lastIndexOf(ruta);
            if (a < 0) {
                return false;    
            } else {
                return true;
            }
        }
    }
});


app.run(['$rootScope', '$location', 'Auth', function ($rootScope, $location, Auth) {
    $rootScope.$on('$routeChangeStart', function (event) {
        var rutablock = $location.path();
        if (!Auth.isLoggedIn()) {
            event.preventDefault();
            swal({
                title: "Lo sentimos acceso denegado",
                type: "warning",
            });
        } else { }
    });
}]);

    