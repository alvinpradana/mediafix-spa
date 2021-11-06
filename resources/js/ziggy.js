const Ziggy = {"url":"http:\/\/mediafix.test","port":null,"defaults":{},"routes":{"invoice.index":{"uri":"invoice","methods":["GET","HEAD"]},"invoice.create":{"uri":"invoice\/create","methods":["GET","HEAD"]},"invoice.store":{"uri":"invoice","methods":["POST"]},"invoice.show":{"uri":"invoice\/{invoice}","methods":["GET","HEAD"]},"invoice.edit":{"uri":"invoice\/{invoice}\/edit","methods":["GET","HEAD"]},"invoice.update":{"uri":"invoice\/{invoice}","methods":["PUT","PATCH"]},"invoice.destroy":{"uri":"invoice\/{invoice}","methods":["DELETE"]},"partners.index":{"uri":"partners","methods":["GET","HEAD"]},"partners.create":{"uri":"partners\/create","methods":["GET","HEAD"]},"partners.store":{"uri":"partners","methods":["POST"]},"partners.show":{"uri":"partners\/{partner}","methods":["GET","HEAD"]},"partners.edit":{"uri":"partners\/{partner}\/edit","methods":["GET","HEAD"]},"partners.update":{"uri":"partners\/{partner}","methods":["PUT","PATCH"]},"partners.destroy":{"uri":"partners\/{partner}","methods":["DELETE"]},"employees.index":{"uri":"employees","methods":["GET","HEAD"]},"employees.create":{"uri":"employees\/create","methods":["GET","HEAD"]},"employees.store":{"uri":"employees","methods":["POST"]},"employees.show":{"uri":"employees\/{employee}","methods":["GET","HEAD"]},"employees.edit":{"uri":"employees\/{employee}\/edit","methods":["GET","HEAD"]},"employees.update":{"uri":"employees\/{employee}","methods":["PUT","PATCH"]},"employees.destroy":{"uri":"employees\/{employee}","methods":["DELETE"]},"sparepart.index":{"uri":"sparepart","methods":["GET","HEAD"]},"sparepart.create":{"uri":"sparepart\/create","methods":["GET","HEAD"]},"sparepart.store":{"uri":"sparepart","methods":["POST"]},"sparepart.show":{"uri":"sparepart\/{sparepart}","methods":["GET","HEAD"]},"sparepart.edit":{"uri":"sparepart\/{sparepart}\/edit","methods":["GET","HEAD"]},"sparepart.update":{"uri":"sparepart\/{sparepart}","methods":["PUT","PATCH"]},"sparepart.destroy":{"uri":"sparepart\/{sparepart}","methods":["DELETE"]},"equipment.index":{"uri":"equipment","methods":["GET","HEAD"]},"equipment.create":{"uri":"equipment\/create","methods":["GET","HEAD"]},"equipment.store":{"uri":"equipment","methods":["POST"]},"equipment.show":{"uri":"equipment\/{equipment}","methods":["GET","HEAD"]},"equipment.edit":{"uri":"equipment\/{equipment}\/edit","methods":["GET","HEAD"]},"equipment.update":{"uri":"equipment\/{equipment}","methods":["PUT","PATCH"]},"equipment.destroy":{"uri":"equipment\/{equipment}","methods":["DELETE"]},"cash.index":{"uri":"cash","methods":["GET","HEAD"]},"cash.create":{"uri":"cash\/create","methods":["GET","HEAD"]},"cash.store":{"uri":"cash","methods":["POST"]},"cash.show":{"uri":"cash\/{cash}","methods":["GET","HEAD"]},"cash.edit":{"uri":"cash\/{cash}\/edit","methods":["GET","HEAD"]},"cash.update":{"uri":"cash\/{cash}","methods":["PUT","PATCH"]},"cash.destroy":{"uri":"cash\/{cash}","methods":["DELETE"]}}};

if (typeof window !== 'undefined' && typeof window.Ziggy !== 'undefined') {
    Object.assign(Ziggy.routes, window.Ziggy.routes);
}

export { Ziggy };