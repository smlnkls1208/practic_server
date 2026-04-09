<section class="section-heading">
    <h1>Пациенты</h1>
</section>

<section class="panel">
    <div class="panel-header">
        <h2>Список пациентов</h2>
    </div>
    <div class="table-wrap">
        <table class="data-table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Фамилия</th>
                <th>Имя</th>
                <th>Отчество</th>
                <th>Дата рождения</th>
            </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Иванов</td>
                    <td>Иван</td>
                    <td>Иванович</td>
                    <td>1998-05-14</td>
                </tr>
            <tr>
                <td>2</td>
                <td>Петрова</td>
                <td>Анна</td>
                <td>Сергеевна</td>
                <td>2001-11-02</td>
            </tr>
            </tbody>
        </table>
    </div>
</section>

<section class="panel form-panel">
    <div class="panel-header">
        <h2>Добавить пациента</h2>
    </div>
    <form class="stack-form two-columns">
        <label>
            <span>Фамилия</span>
            <input type="text" placeholder="Иванов">
        </label>
        <label>
            <span>Имя</span>
            <input type="text" placeholder="Иван">
        </label>
        <label>
            <span>Отчество</span>
            <input type="text" placeholder="Иванович">
        </label>
        <label>
            <span>Дата рождения</span>
            <input type="date">
        </label>
        <button type="button" class="full-width">Сохранить пациента</button>
    </form>
</section>