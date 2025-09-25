<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajout équipement</title>
</head>
<script>

function cacherQuelqueChose(){
    document.getElementById('ma-div').style.display = 'none';
}

function montrerQuelqueChose(){
    document.getElementById('ma-div').style.display = 'block'
}

function categorieChoix(){
    const categorie = document.querySelector('select[name="categorie"]').value;

    //Cacher toutes les sections
    document.getElementById('section-reseau').style.display = 'none';
    document.getElementById('section-telephonie').style.display = 'none';
    document.getElementById('section-sim').style.display = 'none';
    document.getElementById('type-telephonie').style.display = 'none';

    if (categorie === 'reseau' || categorie === 'serveurs'){
        document.getElementById("section-reseau").style.display = 'block';
    } else if (categorie === 'telephonie') {
        document.getElementById('type-telephonie').style.display = 'block';
    }else console.log("Else");
}

function gererTypeTel(){
    const typeTel = document.querySelector('select[name="type-tel"]').value;

    document.getElementById("section-telephonie").style.display = 'none';
    document.getElementById("section-sim").style.display = 'none';

    if (typeTel === 'telephone') {
        document.getElementById('section-telephonie').style.display = 'block';
        console.log("IF telephone");
    } else if (typeTel === 'carte_sim') {
        document.getElementById('section-sim').style.display = 'block';
    } else console.log("ERROR");
}


</script>
<body>
    <h1>Ajouter équipement :</h1>
    <form>
        <div>
            <select name="categorie" onchange="categorieChoix()">
                <option value="">Sélectionner une catégorie</option>
                <option value="ordinateurs_portables">Ordinateurs portables</option>
                <option value="ordinateurs_bureau">Ordinateurs bureau</option>
                <option value="ordinateurs_industriel">Ordinateurs industriel</option>
                <option value="serveurs">Serveurs</option>
                <option value="reseau">Réseau</option>
                <option value="telephonie">Téléphonie</option>
                <option value="impression">Impression</option>
                <option value="mobilite">Mobilité</option>
                <option value="affichage">Affichage</option>
                <option value="accessoires">Accessoires</option>
                <option value="audio_visio">Audio/Visio</option>
                <option value="securite">Sécurité</option>
                <option value="stockage">Stockage</option>
            </select>
            <div id="type-telephonie" style="display: none;">
                <label>Type de Téléphonie</label>
                <select name="type-tel" onchange="gererTypeTel()">
                    <option value="">Choisir</option>
                    <option value="telephone">Téléphone</option>
                    <option value="carte_sim">Carte Sim</option>
                </select>
            </div>
        </div>
        <div>
            <label>Hostname</label>
            <input type="text" name="hostname">
        </div>
        <div>
            <label>Numéro de série :</label>
            <input type="text" name="numero_serie">
        </div>
        <div>
            <label>Numéro IMMO :</label>
            <input type="text" name="numero_immo">
        </div>
        <div id="ma-div">
            <label>Prix : </label>
            <input type="number" name="prix" step="0.01">
        </div>
        <!--Début Ordinateur-->
        <div id="section-ordinateur" style="display: none;">
            <h3>Information Ordinateur</h3>
            <div>
                <label>Type Ordinateur</label>
                <select>
                    <option value="">Choisir</option>
                    <option value="portable">Portable (WLT)</option>
                    <option value="bureau">Bureau (WDT)</option>
                    <option value="industriel">Industriel (WID)</option>
                </select>
            </div>
            <div>
                <label>VLAN</label>
                <select name="id_vlan">
                    <option value="">Choisir un VLAN</option>
                    <option value="vlan_11">11</option>
                    <option value="vlan_41">41</option>
                </select>
            </div>
            <div>
                <label>DHCP</label>
                <input type="radio" name="dhcp" value="oui" onchange="gererDhcp()">Oui
                <input type="radio" name="dhcp" value="non" onchange="gererDhcp()">Non
            </div>
            <div id="ip-fix" style="display: none;">
                <label>Adresse IP Fixe:</label>
                <input type="text" name="adresse_ip_fixe">
            </div>
            <div>
                <label>Numéro IMMO :</label>
                <input type="text" name="numero_immo" placeholder="INV0">
            </div>
        </div>
        <div>

        </div>
        <!-- Début Réseau -->
        <div id="section-reseau" style="display: none;">
            <h3>Information Réseau</h3>
            <div>
                <label>Adresse IP</label>
                <input type="text" name="adresse_ip">
            </div>
            <div>
                <label>Adresse MAC</label>
                <input type="text" name="adresse_mac">
            </div>
        </div>
        <!-- Fin Réseau -->
        <!-- Début Télèphonie -->
        <div id="section-telephonie" style="display: none;">
            <h3>Information Téléphone</h3>
            <div>
                <label>Modéle :</label>
                <input type="text" name="modele">
            </div>
            <div>
                <label>Numéro de série :</label>
                <input type="text" name="numero_serie">
            </div>
            <div>
                <label>IMEI :</label>
            </div>
        </div>
        <!-- Début Sim-->
        <div id="section-sim" style="display: none;">
            <h3>Information Carte Sim</h3>
            <div>
                <label>Numéro de télephone</label>
                <input type="text" name='numero_tel'>
            </div>
            <div>
                <label>Numéro Carte Sim</label>
                <input type='text' name="numero_serie">
            </div>
        </div>
        <!-- Fin Sim-->
        <button>Ajouter</button>
    </form>
    <div>
        <button onclick="cacherQuelqueChose()">Cacher</button>
        <button onclick="montrerQuelqueChose()">Montrer</button>
    </div>
    
</body>
</html>