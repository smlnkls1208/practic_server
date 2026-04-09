<section class="section-heading">
    <span class="section-kicker">Раздел сотрудника</span>
    <h1>Записи к врачу</h1>
    <p>Здесь собраны таблица записей, блок фильтрации и форма добавления новой записи пациента к врачу.</p>
</section>

<section class="panel filter-panel">
    <div class="panel-header">
        <h2>Текущие записи</h2>
    </div>
    <div class="table-toolbar">
        <div class="filter-grid">
            <label>
                <span>Пациент</span>
                <select>
                    <option value="">Все пациенты</option>
                    <?php foreach (($patients ?? []) as $patient): ?>
                        <option value="<?= (int)$patient->id ?>"><?= htmlspecialchars(trim($patient->surname . ' ' . $patient->name . ' ' . ($patient->patronym ?? ''))) ?></option>
                    <?php endforeach; ?>
                </select>
            </label>
            <label>
                <span>Врач</span>
                <select>
                    <option value="">Все врачи</option>
                    <?php foreach (($doctors ?? []) as $doctor): ?>
                        <option value="<?= (int)$doctor->id ?>"><?= htmlspecialchars(trim($doctor->surname . ' ' . $doctor->name . ' ' . ($doctor->patronym ?? ''))) ?></option>
                    <?php endforeach; ?>
                </select>
            </label>
            <label>
                <span>Дата приема</span>
                <input type="date">
            </label>
            <div class="filter-actions">
                <button type="button">Применить</button>
                <button type="button" class="ghost-button">Сбросить</button>
            </div>
        </div>
    </div>
    <div class="table-wrap">
        <table class="data-table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Пациент</th>
                <th>Врач</th>
                <th>Дата и время</th>
                <th>Действие</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach (($appointments ?? []) as $appointment): ?>
                <tr>
                    <td><?= (int)$appointment->id ?></td>
                    <td><?= htmlspecialchars(trim(($appointment->patient_surname ?? '') . ' ' . ($appointment->patient_name ?? '') . ' ' . ($appointment->patient_patronym ?? ''))) ?></td>
                    <td><?= htmlspecialchars(trim(($appointment->doctor_surname ?? '') . ' ' . ($appointment->doctor_name ?? '') . ' ' . ($appointment->doctor_patronym ?? ''))) ?></td>
                    <td><?= htmlspecialchars($appointment->appointment_at) ?></td>
                    <td><button type="button" class="danger-button">Отменить</button></td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($appointments) || count($appointments) === 0): ?>
                <tr>
                    <td colspan="5" class="empty-cell">Записи пока отсутствуют.</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>

<section class="panel form-panel">
    <div class="panel-header">
        <h2>Добавить запись</h2>
    </div>
    <form class="stack-form two-columns">
        <label class="full-width">
            <span>Пациент</span>
            <select>
                <option value="">Выберите пациента</option>
                <?php foreach (($patients ?? []) as $patient): ?>
                    <option value="<?= (int)$patient->id ?>"><?= htmlspecialchars(trim($patient->surname . ' ' . $patient->name . ' ' . ($patient->patronym ?? ''))) ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <label class="full-width">
            <span>Врач</span>
            <select>
                <option value="">Выберите врача</option>
                <?php foreach (($doctors ?? []) as $doctor): ?>
                    <option value="<?= (int)$doctor->id ?>"><?= htmlspecialchars(trim($doctor->surname . ' ' . $doctor->name . ' ' . ($doctor->patronym ?? ''))) ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <label class="full-width">
            <span>Дата и время приема</span>
            <input type="datetime-local">
        </label>
        <button type="button" class="full-width">Сохранить запись</button>
    </form>
</section>
