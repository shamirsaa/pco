<template>
  <div class="main-content home-container">
      <div class="card">
        <div class="card-header">
          <h5 class="todo-title">Productividad</h5>
          <p class="text-sm-center">Total de casos cerrados y cumplimiento de los mismos </p>
          <div>
            <input id="input-search" type="text" class="form-control" v-model="textSearch" placeholder='Buscar...' value="">
          </div>
        </div>
        <div class="card-body">
          <table class="table table-sm  table-striped table-responsive">
            <thead>
              <tr>
                <th>Posición</th>
                <th>Jugador</th>
                <th>Cerrados</th>
                <th>Cumplimiento ANS</th>
                <th>Productividad</th>
                <th>Fecha</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(todo,index) in todos" :key="index">
                <td>{{ index+1 }}</td>
                <td>{{ todo.username }}</td>
                <td>{{ todo.cerrados }}</td>
                <td>{{ todo.cumplimiento }}%</td>
                <td>{{ todo.productividad }}%</td>
                <td>{{ todo.carga }}</td>
              </tr>
            </tbody>
            <tfoot>
              <tr>
                  <th>Posición</th>
                  <th>Jugador</th>
                  <th>Cerrados</th>
                  <th>Cumplimiento</th>
                  <th>Productividad</th>
                </tr>
            </tfoot>
          </table>
        </div>
        
      </div>
    </div>
</template>

<script>
export default {
  data () {
    return {
      
      todos: [
        {
          title: 'Install the Template',
          completed: false,
         
        }
      ],
       textSearch: '',
    }
  },
  
  mounted () {
    for(var i=0; i<=1; i++){
      if(i==0){
        this.getTodos()
      }else{
        setInterval(this.getTodos, 3000)
      }
    }
    
  },
  methods: {

    async getTodos () {
      let response = await window.axios.get('/api/getDataSMPrueba?username='+this.textSearch)
      this.todos = response.data
      
    }
  
  }
}
</script>

<style scoped>

.home-container{
  margin: 100px 5% 5% 5%;
}
.todo-container {
  background-color: #ffde00;
  padding: 50px;
  min-height: 500px;
}

.todo-field:focus {
  border: 1px solid #ccc;
}

.todo-title {
  font-family: "Roboto", sans-serif;
  font-weight: lighter;
  text-align: center;
}

.todo-block h6 {
  text-align: center;
  text-transform: uppercase;
  color: gray;
}

.remove-link {
  color: #f35a3d;
  position: absolute;
  top: 0;
  line-height: 50px;
  right: 5px;
}

.remove-link:hover {
  color: #f35a3d;
}
.todo-block {
  background: #fff;
  padding: 0.375rem 0.75rem;
  margin-top: 30px;
  height: 200px;
  overflow: auto;
}

.todo-list {
  list-style: none;
  padding: 0;
  font-size: 20px;
}

.todo-list li {
  border-bottom: 1px solid #d9d9d9;
  padding: 10px;
  position: relative;
}

.todo-list li label {
  padding-left: 70px;
  margin: 0;
  color: #333;
}

.todo-list li input[type="checkbox"] {
  outline: none;
  text-align: center;
  width: 40px;
  height: 40px;
  position: absolute;
  top: 0;
  bottom: 0;
  margin: auto 0;
  border: none;
  -webkit-appearance: none;
  appearance: none;
}

.todo-list li .toggle:after {
  content: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="-10 -18 100 135"><circle cx="50" cy="50" r="50" fill="none" stroke="#333" stroke-width="3"/></svg>');
}

.todo-list li .toggle:checked:after {
  content: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="-10 -18 100 135"><circle cx="50" cy="50" r="50" fill="none" stroke="#333" stroke-width="3"/><path fill="#4fc47f" d="M72 25L42 71 27 56l-4 4 20 20 34-52z"/></svg>');
}

@media (max-width: 768px) {
  .todos-container {
    display: none;
  }
}
</style>
