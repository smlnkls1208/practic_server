<section class="section-heading">
    <h1>Записи к врачу</h1>
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
                    <option value="1">Иванов Иван Иванович</option>
                    <option value="2">Петрова Анна Сергеевна</option>
                </select>
            </label>
            <label>
                <span>Врач</span>
                <select>
                    <option value="">Все врачи</option>
                    <option value="1">Смирнов Алексей Петрович</option>
                    <option value="2">Кузнецова Елена Викторовна</option>
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
                <tr>
                    <td>1</td>
                    <td>Иванов Иван Иванович</td>
                    <td>Смирнов Алексей Петрович</td>
                    <td>2026-04-14 10:00</td>
                    <td><button type="button" class="danger-button">Отменить</button></td>
                </tr>
            <tr>
                <td>2</td>
                <td>Петрова Анна Сергеевна</td>
                <td>Кузнецова Елена Викторовна</td>
                <td>2026-04-14 12:30</td>
                <td><button type="button" class="danger-button">Отменить</button></td>
            </tr>
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
                <option value="1">Иванов Иван Иванович</option>
                <option value="2">Петрова Анна Сергеевна</option>
            </select>
        </label>
        <label class="full-width">
            <span>Врач</span>
            <select>
                <option value="">Выберите врача</option>
                <option value="1">Смирнов Алексей Петрович</option>
                <option value="2">Кузнецова Елена Викторовна</option>
            </select>
        </label>
        <label class="full-width">
            <span>Дата и время приема</span>
            <input type="datetime-local">
        </label>
        <button type="button" class="full-width">Сохранить запись</button>
    </form>
</section>