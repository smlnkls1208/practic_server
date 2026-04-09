<section class="section-heading">
    <span class="section-kicker">Раздел сотрудника</span>
    <h1>Пациенты</h1>
    <p>Таблица отображает существующих пациентов. Ниже расположена форма для добавления новой записи.</p>
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
            <?php foreach (($patients ?? []) as $patient): ?>
                <tr>
                    <td><?= (int)$patient->id ?></td>
                    <td><?= htmlspecialchars($patient->surname) ?></td>
                    <td><?= htmlspecialchars($patient->name) ?></td>
                    <td><?= htmlspecialchars($patient->patronym ?? '') ?></td>
                    <td><?= htmlspecialchars($patient->birth_date) ?></td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($patients) || count($patients) === 0): ?>
                <tr>
                    <td colspan="5" class="empty-cell">Пациенты еще не добавлены.</td>
                </tr>
            <?php endif; ?>
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
