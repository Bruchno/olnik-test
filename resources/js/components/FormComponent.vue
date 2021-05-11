<template>
    <div class="container">
          <el-form ref="form" :model="form" label-width="120px" class="demo-form-inline">
          <el-form-item label="Activity name">
              <el-input v-model="form.name"></el-input>
          </el-form-item>
          <el-col :span="11">
          <el-form-item label="PRISE from">
              <el-input v-model="form.price_from" :placeholder="err_placeholder.err_price_from">
              </el-input>
          </el-form-item>
          </el-col>
          <el-col :span="11">
            <el-form-item label="PRISE to">
                 <el-input v-model="form.price_to"  :placeholder="err_placeholder.err_price_to">
                 </el-input>
            </el-form-item>
          </el-col>
          <p></p>
          <el-form-item label="Bedrooms">
             <el-input v-model="form.bedrooms" :placeholder="err_placeholder.err_bedrooms">
             </el-input>
          </el-form-item>
          <el-form-item label="Bathrooms">
             <el-input v-model="form.bathrooms"  :placeholder="err_placeholder.err_bathrooms"></el-input>
          </el-form-item>
          <el-form-item label="Storeys">
            <el-input v-model="form.storeys"  :placeholder="err_placeholder.err_storeys"></el-input>
          </el-form-item>
          <el-form-item label="Garages">
            <el-input v-model="form.garages"  :placeholder="err_placeholder.err_garages"></el-input>
          </el-form-item>
          <p id="global-error" class="err-number"></p>
          <div class="btn-search">
          <el-form-item>
            <el-button type="primary" @click="onSubmit">Search</el-button>
          </el-form-item>
      </div>
    </el-form>

    <hr><div id="search-empty">Нічого не знайдено</div>
    <div id="search-table">
        <el-table
          v-loading="loading"
          :data="tableData"
          style="width: 100%"
          height="250">
          <el-table-column
            prop="name"
            label="Name"
            width="120">
          </el-table-column>
          <el-table-column
            prop="price"
            label="Price"
            width="120">
          </el-table-column>
          <el-table-column
            prop="bedrooms"
            label="Bedrooms"
            width="120">
          </el-table-column>
          <el-table-column
            prop="bathrooms"
            label="Bathrooms"
            width="120">
          </el-table-column>
          <el-table-column
            prop="storeys"
            label="Storeys"
            width="100">
          </el-table-column>
          <el-table-column
            prop="garages"
            label="Garages"
            width="100">
          </el-table-column>
        </el-table>
      </div>
    </div>
</template>

<script>
    export default {
    data() {
  return {
    form: {
        name: '',
        price_from: '',
        price_to: '',
        bedrooms: '',
        bathrooms: '',
        storeys: '',
        garages: ''
      },
      err_placeholder: {
          err_name: '',
          err_price_from: '',
          err_price_to: '',
          err_bedrooms: '',
          err_bathrooms: '',
          err_storeys: '',
          err_garages: ''
        },
      tableData: [],
      loading: true,
    }
  },
    methods: {
      onSubmit() {
        var newForm = this.form;
        if(this.validate_form(newForm)){
        this.send_axios(newForm);
        }
      },
      validate_form(dataForm){
      var err = [];
      var err_number = [];
      var err_name = '';
      for (var key in dataForm) {
         if(key == 'name'){
           if(dataForm[key] == ''){
              err_name = 'Ввести назву';
           }
         } else {
          if(dataForm[key] == ''){
             err.push(1);
          } else {
            if(!this.roughScale(dataForm[key])){
              err.push(1); err_number.push(1);
              dataForm[key] = '';
              this.err_placeholder['err_' + key] = 'Не число';
            }
          }
         }
      }
      if(err_number.length != 0)
         return false;
      if(err.length == 6 && err_name != ''){
         document.getElementById('global-error').innerHTML = 'Недостатньо даних';
         return false;
      } else if(dataForm.price_from != '' &&
                dataForm.price_to != '' &&
                dataForm.price_from > dataForm.price_to){
        document.getElementById('global-error').innerHTML = 'Нижня межа ціни більша за верхню';
        return false;
      }
      return true;
      },
      roughScale(x) {
      const parsed = parseInt(x, 10);
      if (isNaN(parsed)) { return false; }
      return parsed;
    },
    send_axios(dataForm){
      document.getElementById('search-table').style.display = "block";
      this.tableData = [];
      this.loading = true;
      document.getElementById('search-empty').style.display = "none";
      axios.post('api/result', dataForm)
        .then((response) => {
          if(response.data.length != 0){
          this.tableData = response.data;
          this.loading = false;
          document.getElementById('search-table').style.display = "block";
        } else {
            document.getElementById('search-table').style.display = "none";
            document.getElementById('search-empty').style.display = "block";
           }
        })
        .catch((error) => {
          console.log(error);
      });
   },
},

    }
</script>
<style>
#search-table{
  display: none;
}
#search-empty {
   display: none;
}
.btn-search {
  text-align: center;
}
#global-error {
  color: red;
  text-align: center;
}
.el-input__inner {
max-width: 190px;
}

</style>
