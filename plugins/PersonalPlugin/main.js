function adjustPluginAdminTools(adminToolsInstalled) {

    if (!adminToolsInstalled) {
        return;
    }

    console.log(adminToolsInstalled);

    var authorContent = document.getElementById("quick_edit_author");
    if (authorContent != null) {
        if (authorContent.value.includes("Bieser FR")) {
            authorContent.readOnly = true;
            authorContent.disabled = true;
        }
    }

    var atoHeader = document.getElementById("ato_header");
    if (atoHeader != null) {

        var elements = atoHeader.getElementsByClassName("icon-users");
        while (elements.length > 0) {
            elements[0].parentNode.remove();
        }

        var elements = atoHeader.getElementsByClassName("icon-wrench");
        while (elements.length > 0) {
            elements[0].parentNode.remove();
        }

        var elements = atoHeader.getElementsByClassName("icon-cog");
        while (elements.length > 0) {
            elements[0].parentNode.remove();
        }

        var elements = atoHeader.getElementsByClassName("icon-puzzle");
        while (elements.length > 0) {
            elements[0].parentNode.remove();
        }

        var elements = atoHeader.getElementsByClassName("switcher");
        while (elements.length > 0) {
            elements[0].parentNode.remove();
        }

        var elements = atoHeader.getElementsByClassName("icon-check");
        while (elements.length > 0) {
            elements[0].parentNode.remove();
        }

        var elements = atoHeader.getElementsByClassName("icon-check-empty");
        while (elements.length > 0) {
            elements[0].parentNode.remove();
        }

        // var elements = atoHeader.getElementsByClassName("icon-ato-cancel");
        // while (elements.length > 0) {
        //     elements[0].parentNode.remove();
        // }
    }

    var atoContainer = document.getElementById("ato_container");
    if (atoContainer != null) {
        atoContainer.remove();
    }
}

function adjustAdminPages() {

    var pictureContent = document.getElementById("picture-content");
    if (pictureContent != null) {
        var inputFields = pictureContent.getElementsByTagName("INPUT");
        for (i = 0; i < inputFields.length; i++) {
            if (inputFields[i].name === "author" && inputFields[i].value.includes("Bieser FR")) {
                inputFields[i].readOnly = true;
                inputFields[i].disabled = true;
            }
        }
    }

    var batchContent = document.getElementById("content");
    if (batchContent != null) {
        var inputFields = batchContent.getElementsByTagName("INPUT");
        for (i = 0; i < inputFields.length; i++) {
            if (inputFields[i].name.includes("author-") && inputFields[i].value.includes("Bieser FR")) {
                inputFields[i].readOnly = true;
                inputFields[i].disabled = true;
            }
        }
    }

    /*
      On Picture Properties Page
      Remove picturePreview entries: delete picture, write Metadata, sync Metadata       
    */
    var picturePreview = document.getElementById("picture-preview");

    if (picturePreview != null) {
        var trashIconElem = picturePreview.getElementsByClassName("icon-trash");
        while (trashIconElem.length > 0) {
            trashIconElem[0].parentNode.removeChild(trashIconElem[0]);
        }

        var trashIconElem = picturePreview.getElementsByClassName("icon-docs");
        while (trashIconElem.length > 0) {
            trashIconElem[0].parentNode.removeChild(trashIconElem[0]);
        }

        var trashIconElem = picturePreview.getElementsByClassName("icon-arrows-cw");
        while (trashIconElem.length > 0) {
            trashIconElem[0].parentNode.removeChild(trashIconElem[0]);
        }
    }

    /*
      Remove Delete Action on Batch Manager
    */
    var permitAction = document.getElementById("permitAction");

    if (permitAction != null) {
        var trashIconElem = permitAction.getElementsByClassName("icon-trash");
        while (trashIconElem.length > 0) {
            trashIconElem[0].parentNode.removeChild(trashIconElem[0]);
        }
    }

    var blockMenueBar = document.getElementById("menubar");

    if (blockMenueBar != null) {

        /* Remove -User Konfiguration- */
        var elements = blockMenueBar.getElementsByClassName("icon-users");
        while (elements.length > 0) {
            elements[0].parentNode.parentNode.remove();
        }

        /* Remove -Tools from admin- */
        var elements = blockMenueBar.getElementsByClassName("icon-wrench");
        while (elements.length > 0) {
            elements[0].parentNode.parentNode.remove();
        }

        /* Remove -Tools from admin- */
        var elements = blockMenueBar.getElementsByClassName("icon-cog");
        while (elements.length > 0) {
            elements[0].parentNode.parentNode.remove();
        }

        /* Remove -Tools from admin- */
        var elements = blockMenueBar.getElementsByClassName("icon-puzzle");
        while (elements.length > 0) {
            elements[0].parentNode.parentNode.remove();
        }
    }

    var blockAdminContent = document.getElementById("content");

    if (blockAdminContent != null) {
        /* Remove -Usergroup Konfiguration- */
        var elements = blockAdminContent.getElementsByClassName("icon-group");
        while (elements.length > 0) {
            elements[0].parentNode.remove();
        }

        /* Remove -Usergroup Konfiguration- */
        var elements = blockAdminContent.getElementsByClassName("icon-users");
        while (elements.length > 0) {
            elements[0].parentNode.remove();
        }

        /* Remove -Usergroup Konfiguration- */
        var elements = blockAdminContent.getElementsByClassName("icon-puzzle");
        while (elements.length > 0) {
            elements[0].parentNode.remove();
        }
    }
}