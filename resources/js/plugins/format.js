class Format {
    decimalShow(value, decimals = 2) {
        value = value * 1
        var str = value.toFixed(decimals).toString().split('.')
        var parts = []

        for (var i = str[0].length; i > 0; i -= 3) {
            parts.unshift(str[0].substring(Math.max(0, i - 3), i));
        }

        str[0] = parts.join(' ');

        return str.join(',')
    }

    priceShow(value, currency = 'zł', decimals = 2) {
        return this.decimalShow(value, decimals) + ' ' + currency
    }

    dateShow(value) {
        if (!value) return '';

        const date = new Date(value);
        const day = date.getDate();
        const month = date.getMonth() + 1;
        const year = date.getFullYear();

        return `${day < 10 ? '0' : ''}${day}.${month < 10 ? '0' : ''}${month}.${year}`;
    }

    currentDate() {
        const date = new Date();
        const day = date.getDate();
        const month = date.getMonth() + 1;
        const year = date.getFullYear();

        return `${year}-${month < 10 ? '0' : ''}${month}-${day < 10 ? '0' : ''}${day}`;
    }

    weightShow(value) {
        return this.decimalShow(value) + ' g'
    }
}

export default new Format()
