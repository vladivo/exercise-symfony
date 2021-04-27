import {Type} from "@angular/core";
import {EntityType} from "./entity-type";
import {EntityViewMode} from "./entity-view-mode";

export type EntityComponentMap = Record<EntityType, Record<EntityViewMode, Type<unknown>>>
