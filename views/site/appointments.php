<?php $csrf = app()->auth::generateCSRF(); ?>
<section class="section-heading">
    <h1>Записи к врачу</h1>
</section>

<section class="panel filter-panel">
    <div class="panel-header">
        <h2>Текущие записи</h2>
    </div>
    <div class="table-toolbar">
        <form method="get" class="filter-grid">
            <label>
                <span>Пациент</span>
                <select name="patient_id">
                    <option value="">Все пациенты</option>
                    <?php if (!empty($patients)): ?>
                        <?php foreach ($patients as $patient): ?>
                            <option value="<?= $patient->id ?>" <?= (int)($filters['patient_id'] ?? 0) === (int)$patient->id ? 'selected' : '' ?>>
                                <?= htmlspecialchars(trim($patient->surname . ' ' . $patient->name . ' ' . ($patient->patronym ?? '')), ENT_QUOTES, 'UTF-8', false) ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </label>
            <label>
                <span>Врач</span>
                <select name="doctor_id">
                    <option value="">Все врачи</option>
                    <?php if (!empty($doctors)): ?>
                        <?php foreach ($doctors as $doctor): ?>
                            <option value="<?= $doctor->id ?>" <?= (int)($filters['doctor_id'] ?? 0) === (int)$doctor->id ? 'selected' : '' ?>>
                                <?= htmlspecialchars(trim($doctor->surname . ' ' . $doctor->name . ' ' . ($doctor->patronym ?? '')), ENT_QUOTES, 'UTF-8', false) ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </label>
            <label>
                <span>Дата приема</span>
                <input type="date" name="appointment_date" value="<?= htmlspecialchars($filters['appointment_date'] ?? '', ENT_QUOTES, 'UTF-8', false) ?>">
            </label>
            <div class="filter-actions">
                <button type="submit">Применить</button>
                <a class="ghost-button" href="<?= app()->route->getUrl('/appointments') ?>">Сбросить</a>
            </div>
        </form>
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
            <?php if (!empty($appointments)): ?>
                <?php foreach ($appointments as $appointment): ?>
                    <tr>
                        <td><?= $appointment->id ?></td>
                        <td><?= htmlspecialchars(trim(($appointment->patient->surname ?? '') . ' ' . ($appointment->patient->name ?? '') . ' ' . ($appointment->patient->patronym ?? '')), ENT_QUOTES, 'UTF-8', false) ?></td>
                        <td><?= htmlspecialchars(trim(($appointment->doctor->surname ?? '') . ' ' . ($appointment->doctor->name ?? '') . ' ' . ($appointment->doctor->patronym ?? '')), ENT_QUOTES, 'UTF-8', false) ?></td>
                        <td><?= htmlspecialchars($appointment->appointment_at, ENT_QUOTES, 'UTF-8', false) ?></td>
                        <td>
                            <form method="post" action="<?= app()->route->getUrl('/appointments/cancel') ?>">
                                <input type="hidden" name="csrf_token" value="<?= $csrf ?>">
                                <input type="hidden" name="appointment_id" value="<?= $appointment->id ?>">
                                <button type="submit" class="danger-button">Отменить</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="empty-cell">Записи не найдены.</td>
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
    <form method="post" class="stack-form two-columns">
        <input type="hidden" name="csrf_token" value="<?= $csrf ?>">
        <label class="full-width">
            <span>Пациент</span>
            <?php if (!empty($errors['patient_id'])): ?>
                <p class="error-message"><?= htmlspecialchars($errors['patient_id'], ENT_QUOTES, 'UTF-8', false) ?></p>
            <?php endif; ?>
            <select name="patient_id">
                <option value="">Выберите пациента</option>
                <?php if (!empty($patients)): ?>
                    <?php foreach ($patients as $patient): ?>
                        <option value="<?= $patient->id ?>" <?= (string)($old['patient_id'] ?? '') === (string)$patient->id ? 'selected' : '' ?>>
                            <?= htmlspecialchars(trim($patient->surname . ' ' . $patient->name . ' ' . ($patient->patronym ?? '')), ENT_QUOTES, 'UTF-8', false) ?>
                        </option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </label>
        <label class="full-width">
            <span>Врач</span>
            <?php if (!empty($errors['doctor_id'])): ?>
                <p class="error-message"><?= htmlspecialchars($errors['doctor_id'], ENT_QUOTES, 'UTF-8', false) ?></p>
            <?php endif; ?>
            <select name="doctor_id">
                <option value="">Выберите врача</option>
                <?php if (!empty($doctors)): ?>
                    <?php foreach ($doctors as $doctor): ?>
                        <option value="<?= $doctor->id ?>" <?= (string)($old['doctor_id'] ?? '') === (string)$doctor->id ? 'selected' : '' ?>>
                            <?= htmlspecialchars(trim($doctor->surname . ' ' . $doctor->name . ' ' . ($doctor->patronym ?? '')), ENT_QUOTES, 'UTF-8', false) ?>
                        </option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </label>
        <label class="full-width">
            <span>Дата и время приема</span>
            <?php if (!empty($errors['appointment_at'])): ?>
                <p class="error-message"><?= htmlspecialchars($errors['appointment_at'], ENT_QUOTES, 'UTF-8', false) ?></p>
            <?php endif; ?>
            <input type="datetime-local" name="appointment_at" value="<?= htmlspecialchars($old['appointment_at'] ?? '', ENT_QUOTES, 'UTF-8', false) ?>">
        </label>
        <button type="submit" class="full-width">Сохранить запись</button>
    </form>
</section>