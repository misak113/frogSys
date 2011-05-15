/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

var aktual_uploader;
function uploaderStatusChanged(uploader) {
    if (uploader.getFileCount() == uploader.getFileCountByStatus(2) && uploader.getFileCount() != 0) {
        if (aktual_uploader == "spravce_souboru") {
            spravceSouboru("Soubory byly nahrány.");
        }
        if (aktual_uploader == "SHOP") {
            createAlert("Obrázky byly nahrány.");
            loadShopProdukt(actual_page_part, actual_produkt_id);
        }
        if (aktual_uploader == "GALE") {
            pageRefresh("Obrázky byly nahrány.");
        }
    }
}