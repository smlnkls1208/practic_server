<section class="section-heading">
    <h1>Врачи</h1>
</section>

<section class="panel">
    <div class="panel-header">
        <h2>Список врачей</h2>
    </div>
    <div class="table-wrap">
        <table class="data-table">
            <thead>
            <tr>
                <th>ID</th>
                <th>ФИО</th>
                <th>Должность</th>
                <th>Специализация</th>
                <th>Дата рождения</th>
            </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Смирнов Алексей Петрович</td>
                    <td>Терапевт</td>
                    <td>Общая терапия</td>
                    <td>1980-03-18</td>
                </tr>
            <tr>
                <td>2</td>
                <td>Кузнецова Елена Викторовна</td>
                <td>Педиатр</td>
                <td>Педиатрия</td>
                <td>1987-09-07</td>
            </tr>
            </tbody>
        </table>
    </div>
</section>

<section class="panel form-panel">
    <div class="panel-header">
        <h2>Добавить врача</h2>
    </div>
    <form class="stack-form two-columns">
        <label>
            <span>Фамилия</span>
            <input type="text" placeholder="Петров">
        </label>
        <label>
            <span>Имя</span>
            <input type="text" placeholder="Петр">
        </label>
        <label>
            <span>Отчество</span>
            <input type="text" placeholder="Петрович">
        </label>
        <label>
            <span>Дата рождения</span>
            <input type="date">
        </label>
        <label>
            <span>Должность</span>
            <select>
                <option value="">Выберите должность</option>
                <option value="1">Терапевт</option>
                <option value="2">Хирург</option>
                <option value="3">Педиатр</option>
                <option value="4">Кардиолог</option>
            </select>
        </label>
        <label>
            <span>Специализация</span>
            <select>
                <option value="">Выберите специализацию</option>
                <option value="1">Общая терапия</option>
                <option value="2">Хирургия</option>
                <option value="3">Педиатрия</option>
                <option value="4">Кардиология</option>
            </select>
        </label>
        <button type="button" class="full-width">Сохранить врача</button>
    </form>
</section>