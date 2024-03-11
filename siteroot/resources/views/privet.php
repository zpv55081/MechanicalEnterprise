<style>
    body {
        background-color: darkslategrey
    }
</style>
<form action="generateco" method="get">
    <p>
        <select name="category">
            <option value="">--Please choose an option--</option>
            <option value="bike">Мопед</option>
            <option value="bus">Автобус</option>
            <option value="tractor">Трактор</option>
        </select>
    </p>
    <p>
        <input name="kind" type="radio" value="eo">Ежедневное
    </p>
    <p>
        <input name="kind" type="radio" value="per" checked>Интервальное
    </p>
    <p>
        <input name="kind" type="radio" value="so">Сезонное
    </p>

    <p>
        <input type="submit" value="Рассчитать">
    </p>
</form>
