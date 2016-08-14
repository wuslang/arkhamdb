<?php

namespace AppBundle\Entity;

class Card implements \Serializable
{
	private function snakeToCamel($snake) {
		$parts = explode('_', $snake);
		return implode('', array_map('ucfirst', $parts));
	}
	
	public function serialize() {
		$serialized = [];
		if(empty($this->code)) return $serialized;
	
		$mandatoryFields = [
				'code',
				'deck_limit',
				'position',
				'quantity',
				'name',
				'is_unique'
		];
	
		$optionalFields = [
				'illustrator',
				'flavor',
				'traits',
				'text',
				'cost',
				'octgn_id',
				'subname'
		];
	
		$externalFields = [
				'faction',
				'pack',
				'type'
		];
	
		switch($this->type->getCode()) {
			case 'asset':
				$mandatoryFields[] = 'cost';
				$optionalFields[] = 'will';
				$optionalFields[] = 'lore';
				$optionalFields[] = 'strength';
				$optionalFields[] = 'agility';
				$optionalFields[] = 'wild';
				$optionalFields[] = 'health';
				$optionalFields[] = 'sanity';				
				$optionalFields[] = 'restrictions';
				$optionalFields[] = 'slot';
				break;
			case 'event':
				$mandatoryFields[] = 'cost';
				$optionalFields[] = 'will';
				$optionalFields[] = 'lore';
				$optionalFields[] = 'strength';
				$optionalFields[] = 'agility';
				$optionalFields[] = 'wild';
				$optionalFields[] = 'restrictions';
				break;
			case 'skill':
				$optionalFields[] = 'will';
				$optionalFields[] = 'lore';
				$optionalFields[] = 'strength';
				$optionalFields[] = 'agility';
				$optionalFields[] = 'wild';
				$optionalFields[] = 'restrictions';
				break;
			case 'investigator':
				$mandatoryFields[] = 'will';
				$mandatoryFields[] = 'lore';
				$mandatoryFields[] = 'strength';
				$mandatoryFields[] = 'agility';
				$mandatoryFields[] = 'health';
				$mandatoryFields[] = 'sanity';
				$mandatoryFields[] = 'deck_requirements';
				$mandatoryFields[] = 'deck_options';
				break;
			case "treachery":
				$externalFields[] = "subtype";
				break;
		}
	
		foreach($optionalFields as $optionalField) {
			$getter = 'get' . $this->snakeToCamel($optionalField);
			$serialized[$optionalField] = $this->$getter();
			if(!isset($serialized[$optionalField]) || $serialized[$optionalField] === '') unset($serialized[$optionalField]);
		}
	
		foreach($mandatoryFields as $mandatoryField) {
			$getter = 'get' . $this->snakeToCamel($mandatoryField);
			$serialized[$mandatoryField] = $this->$getter();
		}
	
		foreach($externalFields as $externalField) {
			$getter = 'get' . $this->snakeToCamel($externalField);
			$serialized[$externalField.'_code'] = $this->$getter()->getCode();
		}
	
		ksort($serialized);
		return $serialized;
	}

	public function unserialize($serialized) {
		throw new \Exception("unserialize() method unsupported");
	}
	
    public function toString() {
		return $this->name;
	}
	
	/**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $position;

    /**
     * @var string
     */
    private $code;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $subname;

    /**
     * @var integer
     */
    private $cost;

    /**
     * @var string
     */
    private $text;

    /**
     * @var \DateTime
     */
    private $dateCreation;

    /**
     * @var \DateTime
     */
    private $dateUpdate;

    /**
     * @var integer
     */
    private $quantity;

    /**
     * @var integer
     */
    private $will;

    /**
     * @var integer
     */
    private $lore;

    /**
     * @var integer
     */
    private $strength;

    /**
     * @var integer
     */
    private $agility;

    /**
     * @var integer
     */
    private $wild;

    /**
     * @var integer
     */
    private $xp;

    /**
     * @var integer
     */
    private $health;

    /**
     * @var integer
     */
    private $sanity;
    

    /**
     * @var integer
     */
    private $deckLimit;

    /**
     * @var string
     */
    private $traits;

    /**
     * @var string
     */
    private $deckRequirements;
    
        /**
     * @var string
     */
    private $deckOptions;
    
    /**
     * @var string
     */
    private $restrictions;

    /**
     * @var string
     */
    private $slot;

    /**
     * @var string
     */
    private $flavor;

    /**
     * @var string
     */
    private $illustrator;

    /**
     * @var boolean
     */
    private $isUnique;

    /**
     * @var string
     */
    private $octgnId;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $reviews;

    /**
     * @var \AppBundle\Entity\Pack
     */
    private $pack;

    /**
     * @var \AppBundle\Entity\Type
     */
    private $type;

    /**
     * @var \AppBundle\Entity\Faction
     */
    private $faction;
    
        /**
     * @var \AppBundle\Entity\Subtype
     */
    private $subtype;

    /**
     * @var \AppBundle\Entity\Card
     */
    private $upgrade;

    /**
     * Constructor
     */
    public function __construct()
    {
      $this->reviews = new \Doctrine\Common\Collections\ArrayCollection();
  	}

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set position
     *
     * @param integer $position
     *
     * @return Card
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return integer
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set code
     *
     * @param string $code
     *
     * @return Card
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Card
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    
    
        /**
     * Set subname
     *
     * @param string $subname
     *
     * @return Card
     */
    public function setSubname($subname)
    {
        $this->subname = $subname;

        return $this;
    }

    /**
     * Get subname
     *
     * @return string
     */
    public function getSubname()
    {
        return $this->subname;
    }

    /**
     * Set cost
     *
     * @param integer $cost
     *
     * @return Card
     */
    public function setCost($cost)
    {
        $this->cost = $cost;

        return $this;
    }

    /**
     * Get cost
     *
     * @return integer
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * Set text
     *
     * @param string $text
     *
     * @return Card
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set dateCreation
     *
     * @param \DateTime $dateCreation
     *
     * @return Card
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    /**
     * Get dateCreation
     *
     * @return \DateTime
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * Set dateUpdate
     *
     * @param \DateTime $dateUpdate
     *
     * @return Card
     */
    public function setDateUpdate($dateUpdate)
    {
        $this->dateUpdate = $dateUpdate;

        return $this;
    }

    /**
     * Get dateUpdate
     *
     * @return \DateTime
     */
    public function getDateUpdate()
    {
        return $this->dateUpdate;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     *
     * @return Card
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return integer
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set health
     *
     * @param integer $health
     *
     * @return Card
     */
    public function setHealth($health)
    {
        $this->health = $health;

        return $this;
    }

    /**
     * Get health
     *
     * @return integer
     */
    public function getHealth()
    {
        return $this->health;
    }

    /**
     * Set sanity
     *
     * @param integer $sanity
     *
     * @return Card
     */
    public function setSanity($sanity)
    {
        $this->sanity = $sanity;

        return $this;
    }

    /**
     * Get sanity
     *
     * @return integer
     */
    public function getSanity()
    {
        return $this->sanity;
    }

    /**
     * Set deckLimit
     *
     * @param integer $deckLimit
     *
     * @return Card
     */
    public function setDeckLimit($deckLimit)
    {
        $this->deckLimit = $deckLimit;

        return $this;
    }

    /**
     * Get deckLimit
     *
     * @return integer
     */
    public function getDeckLimit()
    {
        return $this->deckLimit;
    }

    /**
     * Set will
     *
     * @param integer $will
     *
     * @return Card
     */
    public function setWill($will)
    {
        $this->will = $will;

        return $this;
    }

    /**
     * Get will
     *
     * @return integer
     */
    public function getWill()
    {
        return $this->will;
    }
    
        /**
     * Set lore
     *
     * @param integer $lore
     *
     * @return Card
     */
    public function setLore($lore)
    {
        $this->lore = $lore;

        return $this;
    }

    /**
     * Get lore
     *
     * @return integer
     */
    public function getLore()
    {
        return $this->lore;
    }
    
    
        /**
     * Set strength
     *
     * @param integer $strength
     *
     * @return Card
     */
    public function setStrength($strength)
    {
        $this->strength = $strength;

        return $this;
    }

    /**
     * Get strength
     *
     * @return integer
     */
    public function getStrength()
    {
        return $this->strength;
    }
    
    
        /**
     * Set agility
     *
     * @param integer $agility
     *
     * @return Card
     */
    public function setAgility($agility)
    {
        $this->agility = $agility;

        return $this;
    }

    /**
     * Get agility
     *
     * @return integer
     */
    public function getAgility()
    {
        return $this->agility;
    }
    
        /**
     * Set wild
     *
     * @param integer $wild
     *
     * @return Card
     */
    public function setWild($wild)
    {
        $this->wild = $wild;

        return $this;
    }

    /**
     * Get wild
     *
     * @return integer
     */
    public function getWild()
    {
        return $this->wild;
    }

    /**
     * Set xp
     *
     * @param integer $xp
     *
     * @return Card
     */
    public function setXp($xp)
    {
        $this->xp = $xp;

        return $this;
    }

    /**
     * Get xp
     *
     * @return integer
     */
    public function getXp()
    {
        return $this->xp;
    }

    /**
     * Set traits
     *
     * @param string $traits
     *
     * @return Card
     */
    public function setTraits($traits)
    {
        $this->traits = $traits;

        return $this;
    }

    /**
     * Get traits
     *
     * @return string
     */
    public function getTraits()
    {
        return $this->traits;
    }
    
    
    /**
     * Set deckRequirements
     *
     * @param string $deckRequirements
     *
     * @return Card
     */
    public function setDeckRequirements($deckRequirements)
    {
        $this->deckRequirements = $deckRequirements;

        return $this;
    }

    /**
     * Get deckRequirements
     *
     * @return string
     */
    public function getDeckRequirements()
    {
        return $this->deckRequirements;
    }
    
    
        /**
     * Set deckOptions
     *
     * @param string $deckOptions
     *
     * @return Card
     */
    public function setDeckOptions($deckOptions)
    {
        $this->deckOptions = $deckOptions;
        return $this;
    }

    /**
     * Get deckOptions
     *
     * @return string
     */
    public function getdeckOptions()
    {
        return $this->deckOptions;
    }
    
        /**
     * Set restrictions
     *
     * @param string $restrictions
     *
     * @return Card
     */
    public function setRestrictions($restrictions)
    {
        $this->restrictions = $restrictions;

        return $this;
    }

    /**
     * Get restrictions
     *
     * @return string
     */
    public function getRestrictions()
    {
        return $this->restrictions;
    }
    
        /**
     * Set slot
     *
     * @param string $slot
     *
     * @return Card
     */
    public function setSlot($slot)
    {
        $this->slot = $slot;

        return $this;
    }

    /**
     * Get slot
     *
     * @return string
     */
    public function getSlot()
    {
        return $this->slot;
    }

    /**
     * Set flavor
     *
     * @param string $flavor
     *
     * @return Card
     */
    public function setFlavor($flavor)
    {
        $this->flavor = $flavor;

        return $this;
    }

    /**
     * Get flavor
     *
     * @return string
     */
    public function getFlavor()
    {
        return $this->flavor;
    }

    /**
     * Set illustrator
     *
     * @param string $illustrator
     *
     * @return Card
     */
    public function setIllustrator($illustrator)
    {
        $this->illustrator = $illustrator;

        return $this;
    }

    /**
     * Get illustrator
     *
     * @return string
     */
    public function getIllustrator()
    {
        return $this->illustrator;
    }

    /**
     * Set isUnique
     *
     * @param boolean $isUnique
     *
     * @return Card
     */
    public function setIsUnique($isUnique)
    {
        $this->isUnique = $isUnique;

        return $this;
    }

    /**
     * Get isUnique
     *
     * @return boolean
     */
    public function getIsUnique()
    {
        return $this->isUnique;
    }



    /**
     * Set octgnId
     *
     * @param boolean $octgnId
     *
     * @return Card
     */
    public function setOctgnId($octgnId)
    {
        $this->octgnId = $octgnId;

        return $this;
    }

    /**
     * Get octgnId
     *
     * @return boolean
     */
    public function getOctgnId()
    {
        return $this->octgnId;
    }

    /**
     * Add review
     *
     * @param \AppBundle\Entity\Review $review
     *
     * @return Card
     */
    public function addReview(\AppBundle\Entity\Review $review)
    {
        $this->reviews[] = $review;

        return $this;
    }

    /**
     * Remove review
     *
     * @param \AppBundle\Entity\Review $review
     */
    public function removeReview(\AppBundle\Entity\Review $review)
    {
        $this->reviews->removeElement($review);
    }

    /**
     * Get reviews
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getReviews()
    {
        return $this->reviews;
    }

    /**
     * Set pack
     *
     * @param \AppBundle\Entity\Pack $pack
     *
     * @return Card
     */
    public function setPack(\AppBundle\Entity\Pack $pack = null)
    {
        $this->pack = $pack;

        return $this;
    }

    /**
     * Get pack
     *
     * @return \AppBundle\Entity\Pack
     */
    public function getPack()
    {
        return $this->pack;
    }

    /**
     * Set type
     *
     * @param \AppBundle\Entity\Type $type
     *
     * @return Card
     */
    public function setType(\AppBundle\Entity\Type $type = null)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return \AppBundle\Entity\Type
     */
    public function getType()
    {
        return $this->type;
    }
    
        /**
     * Set subtype
     *
     * @param \AppBundle\Entity\Subtype $type
     *
     * @return Card
     */
    public function setSubtype(\AppBundle\Entity\Subtype $subtype = null)
    {
        $this->subtype = $subtype;

        return $this;
    }

    /**
     * Get subtype
     *
     * @return \AppBundle\Entity\Subtype
     */
    public function getSubtype()
    {
        return $this->subtype;
    }

    /**
     * Set faction
     *
     * @param \AppBundle\Entity\Faction $faction
     *
     * @return Card
     */
    public function setFaction(\AppBundle\Entity\Faction $faction = null)
    {
        $this->faction = $faction;

        return $this;
    }

    /**
     * Get faction
     *
     * @return \AppBundle\Entity\Faction
     */
    public function getFaction()
    {
        return $this->faction;
    }
    
        /**
     * set Upgrade
     *
     * @param \AppBundle\Entity\Card $card
     *
     * @return Card
     */
    public function setUpgrade(\AppBundle\Entity\Card $upgrade = null)
    {
        $this->upgrade = $upgrade;

        return $this;
    }

    /**
     * Get faction
     *
     * @return \AppBundle\Entity\Faction
     */
    public function getUpgrade()
    {
        return $this->upgrade;
    }
    
}
