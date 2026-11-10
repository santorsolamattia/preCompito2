            <?php 
            $risultato = null;
            $errore = null;

            if (isset($_GET['a']) && isset($_GET['b'])) {
                $a = filter_input(INPUT_GET, 'a', FILTER_VALIDATE_FLOAT);
                $b = filter_input(INPUT_GET, 'b', FILTER_VALIDATE_FLOAT);
                $operazione = isset($_GET['operazione']) ? $_GET['operazione'] : '';
                $opzioni = isset($_GET['opzioni']) && is_array($_GET['opzioni']) ? $_GET['opzioni'] : array();

                if ($a === false || $b === false) {
                    $errore = "Inserisci numeri validi per 'a' e 'b'.";
                } else {
                    // Calcolo operazione principale
                    switch ($operazione) {
                        case 'somma':
                            $risultato = $a + $b;
                            break;
                        case 'differenza':
                            $risultato = $a - $b;
                            break;
                        case 'prodotto':
                            $risultato = $a * $b;
                            break;
                        case 'quoziente':
                            if ($b == 0) {
                                $errore = "Impossibile dividere per zero!";
                            } else {
                                $risultato = $a / $b;
                            }
                            break;
                        default:
                            $errore = "Seleziona un'operazione.";
                    }

                    // Applicazione delle opzioni aggiuntive
                    if ($risultato !== null && $errore === null) {
                        if (in_array('absolute', $opzioni)) {
                            $risultato = abs($risultato);
                        }
                        if (in_array('square', $opzioni)) {
                            $risultato = pow($risultato, 2);
                        }
                        if (in_array('round', $opzioni)) {
                            $risultato = round($risultato, 2);
                        }
                    }
                }
            }
            ?>
            <!DOCTYPE html>
            <html lang="it">
            <head>
                <meta charset="UTF-8">
                <title>Calcolatrice</title>
            </head>
            <body>

                <h1>Calcolatrice</h1>

                <?php if ($errore !== null): ?>
                    <p style="color: red;"><?php echo htmlspecialchars($errore); ?></p>
                <?php endif; ?>

                <?php if ($risultato !== null): ?>
                    <h2>Risultato: <?php echo htmlspecialchars($risultato); ?></h2>
                <?php endif; ?>

                <form method="get" action="">
                    <label for="a">a:</label>
                    <input type="number" step="any" id="a" name="a" value="<?php echo isset($_GET['a']) ? htmlspecialchars($_GET['a']) : ''; ?>" required><br><br>
                    
                    <label for="b">b:</label>
                    <input type="number" step="any" id="b" name="b" value="<?php echo isset($_GET['b']) ? htmlspecialchars($_GET['b']) : ''; ?>" required><br><br>

                    <fieldset>
                        <legend>Operazione</legend>
                        <div>
                            <input id="som" type="radio" name="operazione" value="somma" <?php echo (isset($_GET['operazione']) && $_GET['operazione'] === 'somma') ? 'checked' : ''; ?> required> 
                            <label for="som">somma</label>
                        </div> 
                        <div>
                            <input id="dif" type="radio" name="operazione" value="differenza" <?php echo (isset($_GET['operazione']) && $_GET['operazione'] === 'differenza') ? 'checked' : ''; ?>> 
                            <label for="dif">differenza</label>
                        </div>
                        <div>
                            <input id="pro" type="radio" name="operazione" value="prodotto" <?php echo (isset($_GET['operazione']) && $_GET['operazione'] === 'prodotto') ? 'checked' : ''; ?>> 
                            <label for="pro">prodotto</label>
                        </div>
                        <div>
                            <input id="quo" type="radio" name="operazione" value="quoziente" <?php echo (isset($_GET['operazione']) && $_GET['operazione'] === 'quoziente') ? 'checked' : ''; ?>> 
                            <label for="quo">quoziente</label>
                        </div>
                    </fieldset>

                    <br>

                    <fieldset>
                        <legend>Opzioni</legend>
                        <div>
                            <input id="abs" type="checkbox" name="opzioni[]" value="absolute" <?php echo (isset($_GET['opzioni']) && in_array('absolute', $_GET['opzioni'])) ? 'checked' : ''; ?>> 
                            <label for="abs">Valore assoluto</label>
                        </div> 
                        <div>
                            <input id="square" type="checkbox" name="opzioni[]" value="square" <?php echo (isset($_GET['opzioni']) && in_array('square', $_GET['opzioni'])) ? 'checked' : ''; ?>> 
                            <label for="square">Quadrato</label>
                        </div>
                        <div>
                            <input id="round" type="checkbox" name="opzioni[]" value="round" <?php echo (isset($_GET['opzioni']) && in_array('round', $_GET['opzioni'])) ? 'checked' : ''; ?>> 
                            <label for="round">Arrotonda a 2 decimali</label>
                        </div>
                    </fieldset>

                    <br>
                    <input type="submit" value="Calcola">
                </form>

            </body>
            </html>