<?php
$mensagem  = "<table width=100% border=0><tr>";
$mensagem .= '<td class="flex-out">
<div style="display: block; text-align: center; margin: 0 auto">
  <a
    href="https://ntbarenas.000webhostapp.com/home.php"
    style="display: block; border: none"
    ><img src="https://i.ibb.co/8751HZh/AMMHeader.png" alt="Ma-Ma Header" border="0"></a>
</div>
</td>';
$mensagem .= '<tr><td colspan=2><div
style="
  font-family: Arial, Helvetica, sans-serif;
  color: #393838;
  font-size: 12pt;
  line-height: 18pt;
  text-align: center;
  margin-top: 20px;
"
>
<center>
  <span style="color: #ec6408; font-size: 18.5pt"
    ><strong>Obrigado por se ter registado! </strong></span
  >
</center>
</div>
</td>
</tr>';
$mensagem .= '
<tr><td colspan=2><br/><div
style="
  font-family: Arial, Helvetica, sans-serif;
  color: #393838;
  line-height: 14pt;
  text-align: center;
  margin-top: 10px;
"
>
<center>
  <span style="font-size: 14.5pt"
    ><strong
      >Para ativar a sua conta nino.arenas@gmail.com basta
      <div style="display: block">
        <img
        src="https://preview.wundermanlab.com/amm/20210706/spcr_13.png"
        alt=""
        class="spacer"
        />
    </div>
      carregar na seguinte
      ligação:
    </strong></span
  >
</center>
<div style="display: block">
  <img
    src="https://preview.wundermanlab.com/amm/20210706/spcr_13.png"
    alt=""
    class="spacer"
  />
</div>
<a  class="btn" id="btn-customized" style="font-size: 12pt; margin-top: 10px;" role="button" href="' . $urlPagina . '/login/userVerifyAccount.php?id=' . $id . '&code=' . $code . '"><img src="https://i.ibb.co/f09G72M/cta.png" alt="Clique aqui para ativar" border="0"></a>
<div style="display: block">
  <img
    src="https://preview.wundermanlab.com/amm/20210706/spcr_13.png"
    alt=""
    class="spacer"
  />
</div>
</div></td></tr>';

$mensagem .= '<tr><td colspan=2><div
style="
  font-family: Arial, Helvetica, sans-serif;
  color: #333;
  font-size: 8pt;
  line-height: 10pt;
  text-align: center;
  font-weight: bold;
  margin-top: 5rem;
"
>
Centro Pré e Pós Parto - Rua José da Costa Pedreira No12, 1750-130
Lisboa
<div style="display: block">
  <img
    src="https://preview.wundermanlab.com/amm/20210706/spcr_13.png"
    alt=""
    class="spacer"
  />
</div>
</td
></tr>';
$mensagem .= '<td class="flex-out">
<div style="display: block; text-align: center; margin: 0 auto">
  <a
    style="display: block; border: none"
    ><img
    src="https://i.ibb.co/KWMLns0/footer.jpg"
    alt="Ma-Ma footer"
    class="spacer logoFooter"
  /></a>
</div>
</td></table>';


echo $mensagem;
