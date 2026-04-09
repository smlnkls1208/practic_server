<section class="section-heading">
    <span class="section-kicker">Раздел сотрудника</span>
    <h1>Врачи</h1>
    <p>На странице показаны все врачи из базы данных и форма добавления нового специалиста.</p>
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
            <?php foreach (($doctors ?? []) as $doctor): ?>
                <tr>
                    <td><?= (int)$doctor->id ?></td>
                    <td><?= htmlspecialchars(trim($doctor->surname . ' ' . $doctor->name . ' ' . ($doctor->patronym ?? ''))) ?></td>
                    <td><?= htmlspecialchars($doctor->position_name ?? '') ?></td>
                    <td><?= htmlspecialchars($doctor->specialization_name ?? '') ?></td>
                    <td><?= htmlspecialchars($doctor->birth_date) ?></td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($doctors) || count($doctors) === 0): ?>
                <tr>
                    <td colspan="5" class="empty-cell">Врачи еще не добавлены.</td>
                </tr>
            <?php endif; ?>
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
                <?php foreach (($positions ?? []) as $position): ?>
                    <option value="<?= (int)$position->id ?>"><?= htmlspecialchars($position->name) ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <label>
            <span>Специализация</span>
            <select>
                <option value="">Выберите специализацию</option>
                <?php foreach (($specializations ?? []) as $specialization): ?>
                    <option value="<?= (int)$specialization->id ?>"><?= htmlspecialchars($specialization->name) ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <button type="button" class="full-width">Сохранить врача</button>
    </form>
</section>
