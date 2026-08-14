window.quoteForm = function (items = []) {
    return {
        items: items.length ? items : [{ description: '', quantity: 1, unit_price: 0 }],
        addItem() {
            this.items.push({ description: '', quantity: 1, unit_price: 0 });
        },
        removeItem(index) {
            if (this.items.length > 1) {
                this.items.splice(index, 1);
            }
        },
        lineTotal(item) {
            return (parseFloat(item.quantity) || 0) * (parseFloat(item.unit_price) || 0);
        },
        grandTotal() {
            return this.items.reduce((sum, item) => sum + this.lineTotal(item), 0);
        },
    };
};
