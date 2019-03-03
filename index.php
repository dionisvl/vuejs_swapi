<? require('data.php');?>
<?
$pages_count = $people['count']/count($people['results']);
$uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);
?>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
      integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
      crossorigin="anonymous">

<div id="characters" class="container">
    <input v-model="search" class="form-control" placeholder="Find characters by name or gender or birth_year">

    <table class="table table-striped">
        <thead>
        <tr>
            <th v-for="column in columns">
                <a href="#" @click="sortBy(column)" :class="{ active: sortKey == column }">
                    {{ column }}
                </a>
            </th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="user in filteredUsers">
            <td>{{ user.name }}</td>
            <td>{{ user.gender }}</td>
            <td>{{ user.birth_year }}</td>
        </tr>
        </tbody>
    </table>
    <div class="btn-toolbar">
        <div class="btn-group">
            <? for ($i = 0; $i<=$pages_count; $i++){?>
                <a href="http://<?=$_SERVER['HTTP_HOST'] . $uri_parts[0].'?characters_page='.$i?>">
                    <button class="btn btn-primary"><?=$i?></button>
                </a>
            <?}?>
        </div>
    </div>
</div>

<br>
<hr>
<br>

<div id="films" class="container">
    <input v-model="search" class="form-control" placeholder="Find films by title,episode_id,opening_crawl,producer,release_date">

    <table class="table table-striped">
        <thead>
        <tr>
            <th v-for="column in columns">
                <a href="#" @click="sortBy(column)" :class="{ active: sortKey == column }">
                    {{ column }}
                </a>
            </th>
        </tr>
        </thead>

        <tbody>
        <tr v-for="film in filteredFilms">
            <td>{{ film.title }}</td>
            <td>{{ film.episode_id }}</td>
            <td>{{ film.opening_crawl }}</td>
            <td>{{ film.producer }}</td>
            <td>{{ film.release_date }}</td>
        </tr>
        </tbody>
    </table>
</div>
<?//pre($people);?>
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script>
    new Vue({
        el: '#films',
        data: {
            sortKey: 'title',
            reverse: false,
            search: '',
            columns: ['title', 'episode_id', 'opening_crawl', 'producer', 'release_date'],
            films: <?=json_encode($films_arr)?>
        },
        computed: {
            sortedFilms() {
                const k = this.sortKey;
                return this.films.sort((a, b) => (a[k] < b[k] ? -1 : a[k] > b[k] ? 1 : 0) * [1, -1][+this.reverse]);
            },
            filteredFilms() {
                const s = this.search.toLowerCase();
                return this.sortedFilms.filter(n => Object.values(n).some(m => m.toString().toLowerCase().includes(s)));
            }
        },
        methods: {
            sortBy: function(sortKey) {
                this.reverse = (this.sortKey == sortKey) ? !this.reverse : false;
                this.sortKey = sortKey;
            }
        }
    });

    new Vue({
        el: '#characters',
        data: {
            sortKey: 'name',
            reverse: false,
            search: '',
            columns: ['name', 'gender', 'birth_year'],
            users: <?=json_encode($characters)?>
        },
        computed: {
            sortedUsers() {
                const k = this.sortKey;
                return this.users.sort((a, b) => (a[k] < b[k] ? -1 : a[k] > b[k] ? 1 : 0) * [1, -1][+this.reverse]);
            },
            filteredUsers() {
                const s = this.search.toLowerCase();
                return this.sortedUsers.filter(n => Object.values(n).some(m => m.toString().toLowerCase().includes(s)));
            }
        },
        methods: {
            sortBy: function(sortKey) {
                this.reverse = (this.sortKey == sortKey) ? !this.reverse : false;
                this.sortKey = sortKey;
            }
        }
    });

</script>