<div id="log-page" class="beginner achievePage pagePage">
	<div id="log-wrap">
		<h1 class="pageTitle"><a href="#"><span>Multibanco</span></a></h1>
		<br style="clear: both;">
        <div style="padding: 10px;">
			<p><?php echo $html->image('img_pagamento_PT.gif'); ?></p>

			<p>Pode pagar em qualquer caixa multibanco ou no seu Homebaking utilizando os seguintes dados:</p>

			<p>
				O pagamento feito por Multibanco demora algum tempo a ser processado, pelo que é normal não receber logo o crédito das licitações na sua conta.<br />
				Agradecemos a compreensão a uma questão que somos alheios. Se prefirir ter de imediato as licitações na sua conta, por favor escolha pagamento por Cartão de Crédito (também pela Easypay) ou Paypal.
			</p>

			<p>Muito Obrigado</p>

			<div class="easybank">
				Entidade: <?php echo $easypay['ep_entity']; ?> <br />
				Refer&ecirc;ncia: <?php echo $easypay['ep_reference']; ?> <br />
				Valor: <?php echo $number->currency($easypay['ep_value'], $appConfigurations['currency']); ?>
			</div>

            <?php echo $html->image('easybank.png');?>
        </div>
	</div>
	<div id="log-wrap-end">
    </div>
	</div>
</div>
</div>
<div id="wrap-end"></div>