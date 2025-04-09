@extends('layouts.app')

@section('content')
<style>
  .row-vue {
    display: flex;
    justify-content: space-between;
  }

  .col-drag {
    width: 48%;
    padding-bottom: 50px;
  }

  .dragArea {
    border: 1px solid #ccc;
    padding: 10px;
    min-height: 200px;
    background-color: #f9f9f9;
  }

  .drag-item {
    border: 1px solid #ddd;
    padding: 10px;
    margin-bottom: 5px;
    background-color: #fff;
    cursor: move;
    position: relative;
  }

  .drag-item button {
    position: absolute;
    top: 5px;
    right: 5px;
    cursor: pointer;
  }

  h3 {
    margin-bottom: 10px;
  }

  button {
    padding: 10px 20px;
    margin-bottom: 20px;
    cursor: pointer;
    margin-right: 10px;
  }

  .drag-item-move {
    transition: transform 0.2s;
  }
</style>

<div class="container-drag">
  <div class="card-header">
    <div class="row">
      <div class="col-10">
        <h4 class="card-title m-0 font-weight-bold">
          <i class="fa fa-user"></i> Listado de ofertas de trabajo:
        </h4>
      </div>
    </div>
  </div>
  <div class="card-body">
    <div id="appVue">
      <div class="row-vue" v-for="(applyStatuses, indexRow) in applyStatusesRows" :key="indexRow">
        <div class="col-3 col-drag" v-for="(applyState, indexCol) in applyStatuses" :key="indexCol">
          <h3>
            @{{ applyState }} @{{ indexRow }} @{{ indexCol }} = @{{ calculatedIndex(indexRow, indexCol) }}
          </h3>
          <button @click="addToList(calculatedIndex(indexRow, indexCol), calculatedIndex(indexRow, indexCol))">
            Añadir Elemento
          </button>
          <button @click="removeAllFromList(calculatedIndex(indexRow, indexCol))">
            Eliminar Todos
          </button>
          <draggable class="dragArea"
            :list="getListByIndex(calculatedIndex(indexRow, indexCol))"
            group="items"
            :clone="clone"
            :move="checkMove"
            :animation="200">
            <template #item="{ element, index }">
              <transition-group name="list" tag="div" class="drag-container">
                <div class="drag-item" :key="element.id">
                  @{{ element.title }}
                  <button @click="removeFromList(calculatedIndex(indexRow, indexCol), index)">x</button>
                </div>
              </transition-group>
            </template>
          </draggable>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/axios@0.23.0"></script>
<script src="https://cdn.jsdelivr.net/npm/vue@3.2.26"></script>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0"></script>
<script src="https://cdn.jsdelivr.net/npm/vuedraggable@4.0.0"></script>
<script>
  let idCounter = 10;

  let listaOriginal = [1, 2, 3];
  let listaCopia = listaOriginal;

  listaCopia.push(4);

  console.log(listaOriginal); // [1, 2, 3, 4]
  console.log(listaCopia); // [1, 2, 3, 4]

  const App = {
    data() {
      return {
        lists: Array.from({
          length: 15
        }, () => []), // Arreglo bidimensional para listas
        listsCompare: Array.from({
          length: 15
        }, () => []), // Arreglo bidimensional comparar si hubo cambios en el original
        isLoaddingPag: false,
        isWatching: false,
        applyStatusesRows: [
          ['Deseos', 'A postular', 'Postulado', 'Contactado', '1era entrevista'],
          ['Tecn entrevista', 'Tecn prueba', 'Sipco entrevista', 'Sipco prueba', 'Final entrevista'],
          ['Contratado', 'Rechazado', 'Anulado', 'Postorgado', 'No contactado']
        ],
        apiData: [] // Datos obtenidos vía Axios
      };
    },
    mounted() {
      this.isLoaddingPag = false; // Asegúrate de que se desactive al comienzo
      this.fetchData(); // Obtener datos iniciales
    },
    watch: {
      lists: {
        handler(nuevoValor) {
          if (!this.isLoaddingPag) {
            return;
          }
          
          nuevoValor.forEach((listaActual, index) => {
            if (
              this.listsCompare[index] && // Verifica que exists la lista anterior
              JSON.stringify(listaActual) !== JSON.stringify(this.listsCompare[index]) && // Verifica que las listas son diferentes
              listaActual.length > this.listsCompare[index].length && // Verifica si hay más elementos, es decir, se agregó
              this.isLoaddingPag && // Comprueba que la carga inicial ha terminado
              this.isWatching
            ) {
              // Identificar el nuevo elemento
              const nuevoElemento = listaActual.filter(
                itemActual => !this.listsCompare[index].some(
                  itemAnterior => JSON.stringify(itemActual) === JSON.stringify(itemAnterior)
                )
              );

              if (nuevoElemento.length > 0) {
                console.log("Nuevo elemento encontrado 1:", nuevoElemento);
                console.log("Nuevo elemento encontrado 2:", nuevoElemento[0]);

                // Enviar cambios al servidor
                this.actualizarBDPorCambio(nuevoElemento[0].id, index);
              }
            }

          });

          this.isWatching = true;
          this.listsCompare = JSON.parse(JSON.stringify(this.lists));
        },
        deep: true // Observar cambios dentro del arreglo
      }
    },
    methods: {
      calculatedIndex(indexRow, indexCol) {
        return (indexRow * 5) + indexCol;
      },
      getListByIndex(index) {
        if (!this.lists[index]) {
          this.lists[index] = [];
        }
        return this.lists[index];
      },
      clone(item) {
        return item;
      },
      actualizarBDPorCambio(idJobOffers, newIdApplyStatus) {
        console.log(`Actualizando la BD para la lista ${newIdApplyStatus}:`, idJobOffers);

        axios.patch('/JobOffers/updateJobOfferApplyStatus', {
            idJobOffers,
            newIdApplyStatus: (newIdApplyStatus + 1)
          })
          .then(response => {
            console.log("BD actualizada correctamente:", response.data);
          })
          .catch(error => {
            console.error("Error al actualizar en la BD:", error);
          });
      },
      async fetchData() {
        try {
          const response = await axios.get('/JobOffers/list');
          this.apiData = response.data;
          this.apiData.forEach((apiDatum, index) => {
            const idApplyStatus = (apiDatum.idApplyStatus - 1);
            if (!this.lists[idApplyStatus]) {
              this.lists[idApplyStatus] = [];
            }
            this.lists[idApplyStatus].push(apiDatum);
          });
        } catch (error) {
          console.error('Error al obtener datos:', error);
        }
        this.isLoaddingPag = true;
      }
    }
  };

  Vue.createApp(App).component('draggable', vuedraggable).mount('#appVue');
</script>
@endsection